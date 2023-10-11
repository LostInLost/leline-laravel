<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct()
    {
        DB::select(DB::raw('CALL validasi_pemenang()'));
    }
    
    public function index()
    {
        return view('Account.login', [
            'title' => 'Login Page'
        ]);
    }

    public function login(Request $request)
    {
        $verifikasi = DB::selectOne("CALL authentication(?,?)", [$request->email, $request->password]);
        if ($verifikasi->var_success == true) {
            session()->put(
                'user',
                [
                    'username' => $verifikasi->username,
                    'email' => $verifikasi->email,
                    'fullname' => $verifikasi->nama_lengkap,
                    'level' => $verifikasi->level,
                    'status' => $verifikasi->status,
                    'no_telp' => $verifikasi->no_telp ?? null,
                    'auth_id' => $verifikasi->auth_id
                ]
            );
            return redirect('/');
        }

        return redirect()->back()->with('LoginFailed', 'Username atau Password Salah!');
    }

    public function registerPage()
    {
        return view(
            'Account.register',
            [
                'title' => 'Register Page'
            ]
        );
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'email' => ['required', 'email', 'unique:akun,email', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'password' => ['required', 'min:8', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})']
        ]);

        $register = DB::selectOne('CALL registration(?,?,?,?)', [$request->username, $request
        ->email, $request->password, $request->level ?? 1]);

        if ($register->var_success == true)
            return redirect('/account/login')->with('SuccessCreate', 'Your account have been registered');

            return abort(404);
    }

    public function profile($id)
    {
        if (session()->get('user')['auth_id'] != $id)
        return abort(403, 'Forbidden');

        $account = DB::selectOne('CALL account_profile(?)', [$id]);
        if ($account->var_success == true)
        return view('Account.profile', [
            'user' => $account,
            'title' => 'Profile'
        ]);

        return abort(404);
    }
    
    public function UserVerification(Request $request, $id)
    {
        if (session()->get('user')['auth_id'] != $id)
        return abort(403, 'Forbidden');

        $request->validate([
            'username' => ['required', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'email' => ['required', 'email', "unique:akun,email,". $request->old_email.",email", 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
        ]);
        if (session()->get('user')['level'] != 3)
        {

        $request->validate([
            'nik' => ['required', 'min:9', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'nama_lengkap' => ['required', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'no_telp' => ['required', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
            'alamat' => ['required', 'not_regex:(^\s+|[<>/;:"#$%^&*(){}`?]|\s{2,})'],
        ]);
        }

        if ($request->has('request_verification'))
        {
            $account = DB::selectOne('CALL request_verification(?,?,?,?,?)', [
                $request->nik,
                $request->nama_lengkap,
                $request->alamat,
                $request->no_telp,
                session()->get('user')['auth_id'],
            ]);
        }
        

        if ($request->has('update_profile'))
        {
            $account = DB::selectOne('CALL update_profile(?,?,?,?,?,?,?,?)', [
                session()->get('user')['auth_id'],
                $request->nama_lengkap,
                $request->username,
                $request->password,
                $request->alamat,
                $request->no_telp,
                $request->nik,
                $request->email,
            ]);
        }
        if ($account->var_success == true && $request->has('request_verification'))
        {
            session()->flash('success_request', 'Data berhasil dikirim, akun sedang ditinjau');
            return redirect('/account/'.session()->get('user')['auth_id'].'/profile');
        } 
    
        if ($account->var_success == true && $request->has('update_profile'))
        return redirect('/account/'.session()->get('user')['auth_id'].'/profile')->with('successUpdate', 'Data berhasil disimpan');
        
        return redirect()->back()->with('failedUpdate', $account->var_msg);

    }

    public function adminVerification($id)
    {
        $verification = DB::selectOne('CALL admin_verification(?)', [$id]);
        if ($verification->var_success == true)
        return redirect('/account/dashboard')->with('successVerified', "Akun telah diverifikasi");

        return redirect()->back()->with('errorVerified', 'User belum meminta verifikasi');

    }

    public function adminDeclined($id)
    {
        $declining = DB::selectOne('CALL admin_declined(?)', [$id]);
        if ($declining->var_success == true)
        return redirect('account/dashboard');

        return redirect()->back()->with('errorDeclined', 'Data tidak berhasil ditolak');
    }

    public function penawaranSaya($id)
    {
        $penawaran_saya = DB::select(DB::raw('CALL table_penawaran_saya(?)'), [$id]);
        return view('Dashboard.Pembeli.dashboard', [
            'penawaran' => $penawaran_saya,
        ]);
    }


    public function requestToWinner($id)
    {
        $request = DB::selectOne('CALL minta_verifikasi_pemenang(?, TRUE)', [$id]);
        if ($request->var_success == true)
        return redirect()->back();

        return abort(404);
    }

    public function verificationToShopper($id)
    {
        $validasi = DB::selectOne('CALL verifikasi_pemenang_lelang(?,?, TRUE)', [session()->get('user')['auth_id'] ?? null, $id]);
        return redirect()->away('https:/wa.me/'. preg_replace('/^0/', '62', ($validasi->var_no_telp ?? 'null')). '?text=Saya%20ingin%20memverifikasi%20sebagai%20pemenang%20dari%20barang%20lelang ' . ($validasi->var_nama_barang ?? null) . ' anda');

        return abort(404);
    }

    public function logout()
    {
        session()->flush();
        session()->regenerate();
        return redirect('/');
    }
}
