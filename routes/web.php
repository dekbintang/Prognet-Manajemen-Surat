<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\JenisAgendaController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AgendaKegiatanController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    /**
     * =========================================================
     * READ ONLY (SEMUA USER LOGIN)
     * =========================================================
     */
    Route::resource('kategori', KategoriSuratController::class)
        ->only(['index', 'show'])
        ->parameters(['kategori' => 'kategoriSurat'])
        ->where(['kategoriSurat' => '[0-9]+']);

    Route::resource('jenis-agenda', JenisAgendaController::class)
        ->only(['index', 'show'])
        ->parameters(['jenis-agenda' => 'jenisAgenda'])
        ->where(['jenisAgenda' => '[0-9]+']);

    Route::resource('surat-masuk', SuratMasukController::class)
        ->only(['index', 'show'])
        ->parameters(['surat-masuk' => 'suratMasuk'])
        ->where(['suratMasuk' => '[0-9]+']); // ✅ penting

    Route::resource('surat-keluar', SuratKeluarController::class)
        ->only(['index', 'show'])
        ->parameters(['surat-keluar' => 'suratKeluar'])
        ->where(['suratKeluar' => '[0-9]+']);

    Route::resource('agenda', AgendaKegiatanController::class)
        ->only(['index', 'show'])
        ->parameters(['agenda' => 'agendaKegiatan'])
        ->where(['agendaKegiatan' => '[0-9]+']);

    // Disposisi READ (semua user login boleh lihat)
    Route::scopeBindings()->group(function () {
        Route::get('surat-masuk/{suratMasuk}/disposisi', [DisposisiController::class, 'index'])
            ->whereNumber('suratMasuk')
            ->name('surat-masuk.disposisi.index');
    });

    /**
     * =========================================================
     * WRITE ACCESS (ROLE TERTENTU)
     * =========================================================
     */

    // MASTER DATA -> admin saja
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('kategori', KategoriSuratController::class)
            ->except(['index', 'show'])
            ->parameters(['kategori' => 'kategoriSurat'])
            ->whereNumber('kategoriSurat');

        Route::resource('jenis-agenda', JenisAgendaController::class)
            ->except(['index', 'show'])
            ->parameters(['jenis-agenda' => 'jenisAgenda'])
            ->whereNumber('jenisAgenda');
    });

    // SURAT -> admin + operator
    Route::middleware(['role:admin,operator'])->group(function () {
        Route::resource('surat-masuk', SuratMasukController::class)
            ->except(['index', 'show'])
            ->parameters(['surat-masuk' => 'suratMasuk'])
            ->whereNumber('suratMasuk');

        Route::resource('surat-keluar', SuratKeluarController::class)
            ->except(['index', 'show'])
            ->parameters(['surat-keluar' => 'suratKeluar'])
            ->whereNumber('suratKeluar');
    });

    // AGENDA -> admin + pimpinan
    Route::middleware(['role:admin,pimpinan'])->group(function () {
        Route::resource('agenda', AgendaKegiatanController::class)
            ->except(['index', 'show'])
            ->parameters(['agenda' => 'agendaKegiatan'])
            ->whereNumber('agendaKegiatan');
    });

    // DISPOSISI -> admin + pimpinan
    Route::middleware(['role:admin,pimpinan'])->scopeBindings()->group(function () {
        Route::get('surat-masuk/{suratMasuk}/disposisi/create', [DisposisiController::class, 'create'])
            ->whereNumber('suratMasuk')
            ->name('surat-masuk.disposisi.create');

        Route::post('surat-masuk/{suratMasuk}/disposisi', [DisposisiController::class, 'store'])
            ->whereNumber('suratMasuk')
            ->name('surat-masuk.disposisi.store');

        Route::patch('surat-masuk/{suratMasuk}/disposisi/{disposisi}', [DisposisiController::class, 'update'])
            ->whereNumber('suratMasuk')
            ->whereNumber('disposisi')
            ->name('surat-masuk.disposisi.update');

        Route::delete('surat-masuk/{suratMasuk}/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])
            ->whereNumber('suratMasuk')
            ->whereNumber('disposisi')
            ->name('surat-masuk.disposisi.destroy');
    });

});

require __DIR__.'/auth.php';
