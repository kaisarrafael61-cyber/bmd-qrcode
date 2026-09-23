<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportHistoryController;
use App\Http\Controllers\KirController;
use Illuminate\Support\Facades\Route;

// Redireksi Halaman Utama ke Login
Route::redirect('/', '/login');

// Route Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

// Route Publik dengan Rate Limiter (Bisa diakses tanpa login, misal scan QR)
Route::middleware('throttle:60,1')->group(function () {
    // QR baru memakai ID aset yang unik. Kode barang boleh sama pada beberapa aset.
    Route::get('/aset/qr/{asset}', [AssetController::class, 'publicShow'])->name('assets.public.show');
    Route::get('/aset/qr/{asset}/lookup', [AssetController::class, 'publicLookup'])->name('assets.public.lookup');

    // Tetap layani QR lama yang pernah dibuat saat kode barang masih unik.
    Route::get('/aset/{assetCode}', [AssetController::class, 'publicShowByAssetCode'])->name('assets.public.show.legacy');
    Route::get('/aset/{assetCode}/lookup', [AssetController::class, 'publicLookupByAssetCode'])->name('assets.public.lookup.legacy');

    // Route Publik Baru: Untuk scan QR KIR Ruangan dari HP (Bisa langsung lihat PDF tanpa perlu login)
    Route::get('/scan/ruangan/{ruangan}', [KirController::class, 'streamPdf'])->name('kir.pdf');
});

// Route Khusus Admin (Wajib Auth & Role Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/exports/history', ExportHistoryController::class)->name('exports.history');

    // Route Manajemen Aset
    Route::get('/assets/selection', [AssetController::class, 'selection'])->name('assets.selection');
    Route::post('/assets/export/word', [AssetController::class, 'bulkExportWord'])->name('assets.export.word.bulk');
    Route::get('/assets/{asset}/export-word', [AssetController::class, 'exportWord'])->name('assets.export.word');
    Route::get('/assets/{asset}/download', [AssetController::class, 'download'])->name('assets.download');
    Route::resource('assets', AssetController::class)->parameters(['assets' => 'asset']);

    // Route Fitur Upload & QR Code KIR (Bawaan)
    Route::get('/kir', [KirController::class, 'index'])->name('kir.index');
    Route::post('/kir', [KirController::class, 'store'])->name('kir.store');
    
    // Route Baru: Import File Excel KIR (Sekretariat.xlsx)
    Route::post('/kir/import', [KirController::class, 'import'])->name('kir.import');

    // Route Baru: Stream Preview PDF dari Database
    Route::get('/kir/stream-pdf/{ruangan?}', [KirController::class, 'streamPdf'])->name('kir.stream-pdf');

    // Route Baru: Export / Download PDF dari Database
    Route::get('/kir/export-pdf/{ruangan?}', [KirController::class, 'exportPdf'])->name('kir.export-pdf');

    Route::get('/kir/{id}', [KirController::class, 'show'])->name('kir.show');
});