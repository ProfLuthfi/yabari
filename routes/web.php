<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;



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

/* Halaman Utama */

Route::get('/', [LandingController::class, "index"]);
Route::get('/cari', [LandingController::class, 'cari'])->name('cari');
Route::post('/logout', [DashboardController::class, "logout"]);
/* Kategori */
Route::get('/kategori/{kategori}', [LandingController::class, "kategori"]);
/* Login & Register */
Route::get('/login', [LoginController::class, "index"])->middleware('guest');
Route::post('/login', [LoginController::class, "login"])->name('login');
Route::get('/auth/google/redirect', [SocialiteController::class, "redirecttogoogle"]);
Route::get('/auth/google/callback', [SocialiteController::class, "handlegooglecallback"]);
Route::get('/register', [RegisterController::class, "index"])->middleware('guest');
Route::post('/register', [RegisterController::class, "register"])->name('register');
/* Lupa Password */
Route::get('/lupa-password', [ForgotPasswordController::class, "forgotpassword"]);
Route::post('/lupa-password', [ForgotPasswordController::class, "createtoken"]);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, "resetpassword"])->name('reset-password');
Route::post('/reset-password', [ForgotPasswordController::class, "sendresetpassword"]);

/* Dashboard Admin */
Route::group(['middleware' => ['auth', 'role:0']], function () {
    /* Dashboard Admin */
    Route::get('/admin', [DashboardController::class, "admin"])->name('dashboard-admin');
    Route::get('/admin/profil', [DashboardController::class, "profileadmin"]);
    Route::post('/admin/profil-update', [DashboardController::class, "updateprofileadmin"]);
    Route::post('/admin/password-update', [DashboardController::class, "updatepasswordadmin"]);
    /* Admin Data User */
    Route::get('/admin/pegawai', [PegawaiController::class, "pegawai"]);
    Route::post('/admin/pegawai/tambah-pegawai', [PegawaiController::class, "tambahpegawai"]);
    Route::post('/admin/pegawai/hapus-pegawai', [PegawaiController::class, "deletepegawai"]);
});


Route::group(['middleware' => ['auth', 'role:1,2']], function () {
    /* Profil */
    Route::get('/profil', [DashboardController::class, "profileuser"]);
    Route::post('/profil-update', [DashboardController::class, "updateprofileuser"]);
    Route::post('/password-update', [DashboardController::class, "updatepassworduser"]);
});
