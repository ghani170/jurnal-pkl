<?php

use App\Http\Controllers\Admin\DudiController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\ProfilSIswaController;
use Illuminate\Support\Facades\Route;

// ...existing code...



Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('dashboard');

    // kelola Siswa
    Route::resource('siswa', SiswaController::class);

    // kelola Pembimbing
    Route::resource('pembimbing', PembimbingController::class);

    // kelola Jurusan
    Route::resource('jurusan', JurusanController::class);

    //Kelola Kelas
    Route::resource('kelas', KelasController::class);

    //Kelola Dudi
    Route::resource('dudi', DudiController::class);
});

Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');

    Route::resource('profil', ProfilSIswaController::class);
});

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
