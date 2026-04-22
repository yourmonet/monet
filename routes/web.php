<?php

use App\Http\Controllers\Auth\AnggotaAuthController;
use App\Http\Controllers\Auth\BendaharaAuthController;
use App\Http\Controllers\Auth\PengurusAuthController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\MidtransCallbackController;
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
    });
});

// ─────────────────────────────────────────────────────────
// Redirect /login default ke pilihan role
// ─────────────────────────────────────────────────────────
Route::get('/login', function () {
    return redirect('/user/login');
})->name('login');

require __DIR__.'/auth.php';
