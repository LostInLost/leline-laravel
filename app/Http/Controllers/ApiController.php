<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{
    public function pelelangan($id, Response $response)
    {
        $barang_lelang = DB::select(DB::raw('CALL detail_pelelangan_barang(?)'), [$id]);
        return response()->json([
            'data_lelang' => $barang_lelang,
        ]);
    }

    public function notifLelang($id, $auth_id)
    {
        $notif = DB::select(DB::raw('CALL notifikasi_pelelangan_data(?,?)'), [$id, $auth_id ?? null]);
        return response()->json([
            'notifikasi' => $notif,
        ]);
    }
}
