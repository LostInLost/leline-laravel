<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LeLineController extends Controller
{
    public function __construct()
    {
        DB::select(DB::raw('CALL validasi_pemenang()'));
    }
    
    public function index(Request $request)
    {   
        // $homepage = DB::select(DB::raw('CALL table_homepage(?)'), [$request->search ?? null]);
        $homepage = DB::table('barang_lelang')->whereRaw('tgl_dibuka < CURRENT_TIMESTAMP() AND tgl_ditutup > CURRENT_TIMESTAMP()')
        ->where('status', 2)
        ->when($request->search ?? false, function($query, $data) {
            $query->where('nama_barang', 'LIKE', "%$data%");
        })
        ->when($request->kategori ?? false, function($query, $data){
            $query->where('kategori_id', $data);
        }
        )
        ->get();
        $notifikasi = DB::select(DB::raw('CALL notifikasi_akun(?)'), [session()->get('user')['auth_id'] ?? null]);
        $category = DB::table('kategori')->get();
        return view('Leline.Homepage', [
            'homepage' => $homepage,
            'title'  => 'Selamat Datang di LeLine',
            'notif_personal' => $notifikasi,
            'kategori' => $category,
            'request' => $request->all(),
        ]);
    }

    public function detailBarang($id)
    {
        $detail = DB::selectOne('CALL detail_barang_lelang(?,?)', [$id, session()->get('user')['auth_id'] ?? null]);
        $barang_lelang = DB::select(DB::raw('CALL detail_pelelangan_barang(?)'), [$id]);
        $notifikasi =  DB::select(DB::raw('CALL notifikasi_pelelangan_data(?,?)'), [$id, session()->get('user')['auth_id'] ?? null]);
        $notif_personal = DB::select(DB::raw('CALL notifikasi_akun(?)'), [session()->get('user')['auth_id'] ?? null]);
        if ($detail->var_success == true)
            return view('Leline.detail_barang', [
                'barang' => $detail,
                'pelelangan' => $barang_lelang,
                'notif' => $notifikasi,
                'notif_personal' => $notif_personal,
            ]);

        return abort(403);
    }

    public function daftarBarangLelang(Request $request, $id)
    {
        
        $daftar = DB::selectOne('CALL daftar_barang_lelang(?,?)', [
            $request->id,
            $id,
        ]);
        if ($daftar->var_success)
            return redirect()->back()->with('successDaftar', 'lol');

        if ($daftar->var_status == 2 && session()->has('user'))
            return redirect('/account/' . session()->get('user')['auth_id'] . '/profile')->with('failedDaftar', '');

        if ($daftar->var_success == false && $daftar->var_status == 3)
            return redirect()->back()->with('failedDaftar', $daftar->var_msg);

        return redirect('/account/login')->with('failedDaftar', $daftar->var_msg);
    }

    public function tawarBarangLelang(Request $request, $id)
    {
        $request->validate([
            'nominal' => ['required', 'integer'],
        ]);

        if (is_float($request->nominal / $request->kelipatan) == true)
            return redirect()->back()->with('FailNominal', 'Nominal harus sesuai dengan kelipatan');

        $tawaran = DB::selectOne('CALL tawar_barang_lelang(?,?,?)', [
            $id,
            session()->get('user')['auth_id'],
            $request->nominal,
        ]);

        if ($tawaran->var_success == true)
            return redirect()->back()->with('successTawaran', 'Harga berhasil ditawarkan');

        return redirect()->back()->with('errorTawaran', $tawaran->var_msg);
    }

    public function tutupLelang($id)
    {
        $close = DB::selectOne('CALL tutup_lelang_data(?,?)', [session()->get('user')['auth_id'] ?? null, $id]);
        if ($close->var_success == true)
        return redirect()->back()->with('successTutup', 'Lelang anda berhasil ditutup');

        return abort(403);

    }
}
