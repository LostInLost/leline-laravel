<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeLineController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'role'], function () {
    Route::get('/account/logout', [AccountController::class, 'logout']);
    Route::get('/account/dashboard', [DashboardController::class, 'index']);
    Route::get('/account/{id}/profile', [AccountController::class, 'profile']);
    Route::post('/account/{id}/request_verification', [AccountController::class, 'UserVerification']);
    Route::get('/request_account/{id}/verified', [AccountController::class, 'adminVerification']);
    Route::get('/request_account/{id}/declined', [AccountController::class, 'adminDeclined']);
    Route::get('/dashboard/barang_saya', [DashboardController::class, 'formProduct']);
    Route::post('/dashboard/{id}/barang_saya', [DashboardController::class, 'addProduct']);
    Route::post('/dashboard/barang_saya/delete', [DashboardController::class, 'deleteProduct']);
    Route::get('/dashboard/barang_saya/{id}/edit', [DashboardController::class, 'formEditProduct']);
    Route::post('/dashboard/barang_saya/edit', [DashboardController::class, 'editProduct']);
    Route::get('/dashboard/barang_saya/{id}/detail', [DashboardController::class, 'formDetailProduct']);
    Route::post('/barang_lelang/{id}/tawar', [LeLineController::class, 'tawarBarangLelang']);
    Route::get('/dashboard/barang/{id}', [DashboardController::class, 'deleteProductAdmin']);
    Route::get('/account/{id}/penawaran_saya', [AccountController::class, 'penawaranSaya']);
    Route::get('/homepage/{id}/tutup_lelang', [LeLineController::class, 'tutupLelang']);
    Route::get('/account/{id}/barang_saya/verification', [AccountController::class , 'requestToWinner']);
    Route::get('/account/{id}/verification/lelang', [AccountController::class, 'verificationToShopper']);
    Route::get('/dashboard/kategori/{id}/hapus', [DashboardController::class, 'deleteKategori']);
    Route::get('/account/kategori', [DashboardController::class, 'kategori']);
    Route::post('/account/kategori', [DashboardController::class, 'kategori_tambah']);
    Route::get('/account/kategori/tambah', [DashboardController::class, 'tambahKategori']);
    Route::get('/account/request_barang', [DashboardController::class, 'request_barang']);
    Route::get('/request_barang/{id}/detail', [DashboardController::class, 'detailRequestBarang']);
    Route::get('/request_barang/{id}/accept', [DashboardController::class, 'acceptBarang']);
    Route::get('/request_barang/{id}/decline', [DashboardController::class, 'declineBarang']);
    Route::get('/barang_saya/{id}/cetak_kontrak', [DashboardController::class, 'invoicePenjual']);
    Route::get('/barang_saya/{id}/accept', [DashboardController::class, 'penjualAcceptKontrak']);
    Route::get('/barang_saya/{id}/decline', [DashboardController::class, 'declineBarang']);
});

Route::get('/account/login', [AccountController::class, 'index'])->middleware('logout');
Route::post('/account/login', [AccountController::class, 'login'])->middleware('logout');
Route::get('/account/register', [AccountController::class, 'registerPage'])->middleware('logout')->name('account.register');
Route::post('/account/register', [AccountController::class, 'register'])->middleware('logout');
Route::get('/', [LeLineController::class, 'index']);
Route::get('/homepage/{id}/detail', [LeLineController::class, 'detailBarang']);
Route::post('/homepage/{id}/detail/daftar', [LeLineController::class, 'daftarBarangLelang']);
