<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\Auth\StudentRegisterController;
use App\Http\Controllers\EkycController;
use App\Http\Controllers\Admin\EkycAdminController;
use App\Http\Controllers\LandingController;

use App\Http\Controllers\Admin\LandingSettingController;
use App\Http\Controllers\Admin\LandingNavController;
use App\Http\Controllers\Admin\LandingProgramController;
use App\Http\Controllers\Admin\LandingFooterController;
use App\Http\Controllers\Admin\TentangController;

use Illuminate\Support\Facades\Route;

// Halaman utama (Landing Page Publik)
Route::get('/', [LandingController::class, 'index'])->name('home');

// Dashboard (setelah login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mahasiswa CRUD
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // Resource lainnya
    Route::resource('ruangan', RuanganController::class);
    Route::resource('matkul', MatkulController::class);
    Route::resource('dosen', DosenController::class);

    // Admin eKYC
    Route::prefix('admin')->group(function () {
        Route::get('/ekyc', [EkycAdminController::class, 'index'])->name('admin.ekyc.index');
        Route::get('/ekyc/{id}', [EkycAdminController::class, 'show'])->name('admin.ekyc.show');
        Route::post('/ekyc/{id}/verify', [EkycAdminController::class, 'verify'])->name('admin.ekyc.verify');
    });

    /** LANDING PAGE CMS - Admin Section */
    Route::prefix('admin/landing')->name('admin.landing.')->group(function () {
        Route::resource('settings', LandingSettingController::class)->only([
            'index', 'store', 'edit', 'update'
        ]);

        Route::resource('navigation', LandingNavController::class)->except(['show']);

        Route::resource('programs', LandingProgramController::class)->except(['show']);

        Route::resource('footer', LandingFooterController::class)->except(['show']);
        Route::post('footer/reorder', [LandingFooterController::class, 'reorder'])->name('footer.reorder');
        Route::patch('footer/{id}/status', [LandingFooterController::class, 'toggleStatus'])->name('footer.toggleStatus');

        Route::get('tentang', [TentangController::class, 'index'])
            ->name('tentang.index');

        Route::put('tentang', [TentangController::class, 'update'])
            ->name('tentang.update');
    });
});

// Registrasi Mahasiswa (publik)
Route::get('/register-mahasiswa', [StudentRegisterController::class, 'showRegistrationForm'])
    ->name('register.mahasiswa');
Route::post('/register-mahasiswa', [StudentRegisterController::class, 'register']);

// eKYC Flow (untuk user yang sudah login)
Route::middleware(['auth'])->prefix('ekyc')->group(function () {
    Route::get('status', [EkycController::class, 'step5'])->name('ekyc.status');

    Route::get('step1', [EkycController::class, 'step1'])->name('ekyc.step1');
    Route::post('step1', [EkycController::class, 'storeStep1'])->name('ekyc.storeStep1');

    Route::get('step2', [EkycController::class, 'step2'])->name('ekyc.step2');
    Route::post('step2', [EkycController::class, 'storeStep2'])->name('ekyc.step2.store');

    Route::get('step3', [EkycController::class, 'step3'])->name('ekyc.step3');
    Route::post('step3', [EkycController::class, 'storeStep3'])->name('ekyc.step3.store');

    Route::get('step4', [EkycController::class, 'step4'])->name('ekyc.step4');
    Route::post('step4', [EkycController::class, 'storeStep4'])->name('ekyc.step4.store');

    Route::get('step5', [EkycController::class, 'step5'])->name('ekyc.step5');
});

require __DIR__.'/auth.php';
