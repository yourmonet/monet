<?php

use App\Http\Controllers\Auth\AnggotaAuthController;
use App\Http\Controllers\Auth\BendaharaAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PengurusAuthController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\StatusPembayaranController;
use App\Http\Controllers\KategoriTransaksiController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────
// Landing Page
// ─────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// Callback Midtrans (Sebaiknya pastikan route ini dikecualikan dari CSRF token)
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleCallback'])->name('midtrans.callback');
Route::post('/midtrans/callback-keluar', [MidtransCallbackController::class, 'handleCallbackKeluar'])->name('midtrans.callback-keluar');

// ─────────────────────────────────────────────────────────
// ANGGOTA — prefix: /user
// ─────────────────────────────────────────────────────────
Route::prefix('user')->name('user.')->group(function () {

    // Public: login & register
    Route::get('login',    [AnggotaAuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [AnggotaAuthController::class, 'login']);
    Route::get('register', [AnggotaAuthController::class, 'showRegister'])->name('register');
    Route::post('register',[AnggotaAuthController::class, 'register']);

    // Protected: dashboard & logout (hanya untuk role anggota)
    Route::middleware(['role:anggota'])->group(function () {
        Route::get('dashboard', [AnggotaAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout',   [AnggotaAuthController::class, 'logout'])->name('logout');
    });
});

// ─────────────────────────────────────────────────────────
// PENGURUS — prefix: /pengurus
// ─────────────────────────────────────────────────────────
Route::prefix('pengurus')->name('pengurus.')->group(function () {

    // Public: login & register
    Route::get('login',    [PengurusAuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [PengurusAuthController::class, 'login']);
    Route::get('register', [PengurusAuthController::class, 'showRegister'])->name('register');
    Route::post('register',[PengurusAuthController::class, 'register']);

    // Protected: dashboard & logout (hanya untuk role pengurus)
    Route::middleware(['role:pengurus'])->group(function () {
        Route::get('dashboard', [PengurusAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout',   [PengurusAuthController::class, 'logout'])->name('logout');
        Route::get('status-pembayaran', [StatusPembayaranController::class, 'index'])->name('status-pembayaran.index');
    });
});

// ─────────────────────────────────────────────────────────
// BENDAHARA — prefix: /bendahara
// ─────────────────────────────────────────────────────────
Route::prefix('bendahara')->name('bendahara.')->group(function () {

    // Public: login & register
    Route::get('login',    [BendaharaAuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [BendaharaAuthController::class, 'login']);
    Route::get('register', [BendaharaAuthController::class, 'showRegister'])->name('register');
    Route::post('register',[BendaharaAuthController::class, 'register']);

    // Protected: dashboard & logout (hanya untuk role bendahara)
    Route::middleware(['role:bendahara'])->group(function () {
        Route::get('dashboard', [BendaharaAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout',   [BendaharaAuthController::class, 'logout'])->name('logout');
        Route::resource('kas-masuk', KasMasukController::class)->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('kas-keluar', KasKeluarController::class)->only(['index', 'create', 'store']);
        
        // Route Baru: Kategori Transaksi
        Route::resource('kategori', KategoriTransaksiController::class);
        
        Route::get('laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');
        Route::get('laporan-keuangan/pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('laporan-keuangan/excel', [LaporanKeuanganController::class, 'exportExcel'])->name('laporan.excel');
        Route::get('profil-saya', [\App\Http\Controllers\ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('profil-saya', [\App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
        Route::resource('manajemen-data-anggota', \App\Http\Controllers\Bendahara\ManajemenAnggotaController::class);
        
        Route::get('status-pembayaran', [StatusPembayaranController::class, 'index'])->name('status-pembayaran.index');
        Route::post('status-pembayaran/generate', [StatusPembayaranController::class, 'generateBulanIni'])->name('status-pembayaran.generate');
    });
});

// ─────────────────────────────────────────────────────────
// GOOGLE OAUTH
// ─────────────────────────────────────────────────────────
// PENTING: callback & complete harus didefinisikan SEBELUM {role}
// agar Laravel tidak menganggap "callback" sebagai nilai role.
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleCallback'])->name('auth.google.callback');
Route::get('/auth/google/complete', [GoogleAuthController::class, 'showCompleteProfile'])->name('auth.google.complete');
Route::post('/auth/google/complete',[GoogleAuthController::class, 'completeProfile'])->name('auth.google.complete.post');
Route::get('/auth/google/{role}',   [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');

// ─────────────────────────────────────────────────────────
// PROFIL — prefix: /profil
// ─────────────────────────────────────────────────────────
// Profil sudah dipindah ke bendahara.

Route::get('/login', function () {
    return redirect('/user/login');
})->name('login');

require __DIR__.'/auth.php';
