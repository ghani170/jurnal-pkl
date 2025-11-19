<?php

use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\DudiController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pembimbing\AbsensiSiswaController;
use App\Http\Controllers\Pembimbing\DashboardPembimbingController;
use App\Http\Controllers\Pembimbing\KegiatanSiswaController;
use App\Http\Controllers\Siswa\AbsensiController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\KegiatanController;
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

    //Kelola Kegiatan
    Route::resource('kegiatan', AdminKegiatanController::class);

    //Kelola Absensi
    Route::resource('absensi', AdminAbsensiController::class);
});

Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {


    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');
    // Profil & Kegiatan
    Route::resource('profil', ProfilSIswaController::class);
    Route::resource('kegiatan', KegiatanController::class);

    // Absensi
    Route::resource('absensi', AbsensiController::class);
    Route::get('kegiatan/per-bulan', [KegiatanController::class, 'perBulan'])
        ->name('kegiatan.perBulan');
});
Route::prefix('pembimbing')->name('pembimbing.')->middleware(['auth', 'role:pembimbing'])->group(function () {
    Route::get('/dashboard', [DashboardPembimbingController::class, 'index'])->name('dashboard');

    Route::resource('kegiatansiswa', KegiatanSiswaController::class);
    Route::resource('absensisiswa', AbsensiSiswaController::class);
    Route::resource('lihatsiswa', \App\Http\Controllers\Pembimbing\SiswaController::class);
    Route::get('/lihatkegiatan/{id}', [\App\Http\Controllers\Pembimbing\SiswaController::class, 'siswakegiatan'])->name('siswa.kegiatan');
    Route::get('/lihatabsensi/{id}', [\App\Http\Controllers\Pembimbing\SiswaController::class, 'siswaabsensi'])->name('siswa.absensi');
    
});
Route::prefix('pembimbingDudi')->name('pembimbingDudi.')->middleware(['auth', 'role:pembimbing_dudi'])->group(function () {
    Route::get('/dashboard', [DashboardPembimbingController::class, 'index'])->name('dashboard');
});




Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
