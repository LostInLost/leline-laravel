<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{

    public function __construct()
    {
        DB::select(DB::raw('CALL validasi_pemenang()'));
    }

    public function index()
    {
        if (session()->get('user')['level'] != 1) {
            $barang_saya = DB::select(DB::raw('CALL table_barang_saya(?)'), [session()->get('user')['auth_id']]);
            $request_verification = DB::select(DB::raw('CALL table_request_verification()'));
            $laporan_penjual = DB::select(DB::raw('CALL table_laporan_penjual(?)'), [session()->get('user')['auth_id']]);
            $laporan_admin = DB::select(DB::raw('CALL laporan_administrator()'));
            $category = DB::table('kategori')->get();
            return view('Dashboard.index', [
                'request_verification_count' => count($request_verification),
                'request_verification' => $request_verification,
                'barang_saya' => $barang_saya,
                'laporan_penjual' => $laporan_penjual,
                'laporan_admin' => $laporan_admin,
                'kategori' => $category,
                'title' => 'Dashboard',
            ]);
        }
        return redirect('/');
    }

    public function formProduct()
    {
        if (session()->get('user')['level'] != 2)
        return abort(403);
        
        $category = DB::table('kategori')->get();
        return view('Dashboard.Penjual.add_product', [
            'kategori' => $category,
        ]);
    }

    public function addProduct(Request $request, $id)
    {
        if (session()->get('user')['auth_id'] != $id) {
            return abort(403, 'Forbidden');
        }

        if ($request->is_hitungan == false) {
            $request->validate([
                'foto' => ['required', 'mimes:png,jpg,jpeg'],
                'nama_barang' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
                'harga_awal' => ['required', 'integer'],
                'kelipatan' => ['required', 'integer'],
                'tgl_dibuka' => ['required'],
                'tgl_ditutup' => ['required'],
                'time_akhir' => ['required'],
                'kategori' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
                'deskripsi' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
            ]);
        }

        if ($request->is_hitungan == true) {
            $request->validate([
                'foto' => ['required', 'mimes:png,jpg,jpeg'],
                'nama_barang' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
                'harga_awal' => ['required', 'integer'],
                'kelipatan' => ['required', 'integer'],
                'tgl_dibuka' => ['required'],
                'interval' => ['integer'],
                'kategori' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
                'deskripsi' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
            ]);
        }
        $file = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $file = md5(now()) . $foto->getClientOriginalName();
        }
        $barang_lelang = DB::selectOne('CALL insert_barang_lelang(?,?,?,?,?,?,?,?,?,?,?,?,?)', [session()->get('user')['auth_id'], $request->nama_barang, $request->deskripsi, $request->harga_awal, $request->kelipatan, $request->tgl_dibuka, $request->tgl_ditutup, md5(now()) . $request->file('foto')->getClientOriginalName(), preg_replace('/\s+/', '_', strtolower($request->kategori)), $request->time_awal, $request->time_akhir, $request->is_hitungan == true ?? false, $request->interval ?? null]);

        if ($barang_lelang->var_success == true) {
            $foto->move(public_path('images/barang/'), $file);
            return redirect('/account/dashboard')->with('successAddBarang', 'Data berhasil ditambah');
        }
        session()->flash('failsDate', $barang_lelang->var_msg);
        return redirect()
            ->back()
            ->withInput();
    }

    public function deleteProduct(Request $request)
    {
        $delete = DB::selectOne('CALL delete_barang_saya(?,?)', [$request->id, session()->get('user')['auth_id']]);

        if ($delete->var_success == true) {
            File::delete(public_path('/images/barang/' . $delete->var_foto));
            return redirect()->back();
        }
        
        return abort(403);
    }

    public function formEditProduct($id)
    {
        $barang_saya = DB::selectOne('CALL data_barang_saya(?,?)', [$id, session()->get('user')['auth_id']]);
        $category = DB::table('kategori')->get();
        if ($barang_saya->var_success == true) {
            return view('Dashboard.Penjual.edit_product', [
                'barang_saya' => $barang_saya,
                'kategori' => $category,
            ]);
        }

        return abort(404);
    }

    public function editProduct(Request $request)
    {
        $request->validate([
            'foto' => ['mimes:png,jpg,jpeg'],
            'nama_barang' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
            'harga_awal' => ['required', 'integer'],
            'kelipatan' => ['required', 'integer'],
            'tgl_dibuka' => ['required'],
            'tgl_ditutup' => ['required'],
            'kategori' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
            'deskripsi' => ['required', 'not_regex:(^\s+|[<>/"#$%^&*(){}`?]|\s{2,})'],
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $file = md5(now()) . $foto->getClientOriginalName();
        }

        $barang_lelang = DB::selectOne('CALL update_barang_saya(?,?,?,?,?,?,?,?,?,?,?,?)', [$request->id, session()->get('user')['auth_id'], $file ?? $request->old_foto, $request->nama_barang, $request->harga_awal, $request->kelipatan, $request->tgl_dibuka, $request->tgl_ditutup, $request->time_awal, $request->time_akhir, $request->deskripsi, preg_replace('/\s+/', '_', strtolower($request->kategori))]);

        if ($barang_lelang->var_success == true) {
            if ($request->hasFile('foto')) {
                File::delete(public_path('/images/barang/' . $request->old_foto));
                $foto->move(public_path('/images/barang'), $file);
            }
            return redirect('/account/dashboard');
        }

        return redirect()
            ->back()
            ->with('failsDate', $barang_lelang->var_msg)
            ->withInput();
    }

    public function formDetailProduct($id)
    {
        $detail_barang = DB::selectOne('CALL data_barang_saya(?,?)', [$id, session()->get('user')['auth_id']]);

        if ($detail_barang->var_success == true) {
            return view('Dashboard.Penjual.detail_product', [
                'detail' => $detail_barang,
            ]);
        }

        return abort(404);
    }

    public function deleteProductAdmin($id)
    {
        $barang = DB::table('barang_lelang')->where('id', $id)->delete();
        if ($barang)
        return redirect()->back();

        return redirect()->back();
    }

    public function deleteKategori($id)
    {
        $delete = DB::table('kategori')->where('id', $id)->delete();
        if ($delete)
        return redirect('/account/dashboard');

        return redirect()->back();
    }

    public function kategori()
    {
        $category = DB::table('kategori')->get();
        return view('Dashboard.kategori', [
            'kategori' => $category,
        ]);
    }

    public function tambahKategori()
    {
        return view('Dashboard.add_category');
    }

    public function kategori_tambah(Request $request)
    {
        $request->validate([
            'kategori' => 'required', 'unique:kategori,kategori'
        ]);

        $tambah = DB::table('kategori')->insert([
            'nama_kategori' => $request->kategori,
        ]);

        if ($tambah)
        return redirect('/account/kategori')->with('successTambah', '');

        return redirect('/account/kategori')->with('gagalTambah', '');
    }

    public function request_barang()
    {
        $barang = DB::select(DB::raw("CALL table_request_barang()"));
        return view('Dashboard.request_barang', [
            'barang' => $barang,
        ]);
    }

    public function detailRequestBarang($id)
    {
        $detail = DB::selectOne("CALL detail_request_barang(?)", [$id]);
        return view('Dashboard.detail_request_barang', [
            'detail' => $detail,
        ]);
    }

    public function acceptBarang($id)
    {
        $update = DB::selectOne("CALL barang_accepted(?)", [$id]);
        if ($update->var_success == true)
        return redirect('/account/request_barang');

        return redirect('/account/request_barang');
    }

    public function invoicePenjual($id)
    {
        $invoice = DB::selectOne("CALL invoice_penjual(?)", [$id]);
        return view('Dashboard.invoice_penjual', [
            'invoice' => $invoice,
        ]);
    }

    public function declineBarang($id)
    {
        $update = DB::selectOne("CALL kontrak_declined(?)", [$id]);
        if ($update->var_success == true)
        return redirect('/account/request_barang');

        return redirect('/account/request_barang');
    }

    public function penjualAcceptKontrak($id)
    {
        $update = DB::selectOne("CALL penjual_accepted(?)", [$id]);
        if ($update->var_success == true)
            return redirect('/account/dashboard');

        return redirect('/account/dashboard');
    }
}
