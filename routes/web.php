<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailUndanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataEkskulController;
use App\Http\Controllers\Admin\DataHasilTesController;
use App\Http\Controllers\admin\DataPembinaController;
use App\Http\Controllers\Admin\DataRekrutmenController;
use App\Http\Controllers\admin\DataSiswaController;
use App\Http\Controllers\Admin\JadwalTesController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Siswa\SiswaController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

//admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashbord', [AdminController::class, 'dashboard'])->name('index');
    // Admin
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('admin');
        Route::get('/admin/create', 'create')->name('admin.create');
        Route::post('/admin/save', 'store')->name('admin.save');
        Route::get('/admin/edit/{id_admin}', 'edit')->name('admin.edit');
        Route::post('/admin/update/{id_admin}', 'update')->name('admin.update');
        Route::delete('/admin/{id_admin}', 'destroy')->name('admin.destroy');
        Route::get('/admin/cetak', 'pdf')->name('admin.cetak');
    });
    // Pembina
    Route::controller(DataPembinaController::class)->group(function () {
        Route::get('/pembina', 'index')->name('pembina');
        Route::get('/pembina/create', 'create')->name('pembina.create');
        Route::post('/pembina/save', 'store')->name('pembina.save');
        Route::get('/pembina/edit/{id_pembina}', 'edit')->name('pembina.edit');
        Route::post('/pembina/update/{id_pembina}', 'update')->name('pembina.update');
        Route::delete('/pembina/{id_pembina}', 'destroy')->name('pembina.destroy');
        Route::get('/pembina/cetak', 'pdf')->name('pembina.cetak');
    });
    // Siswa
    Route::controller(DataSiswaController::class)->group(function () {
        Route::get('/siswa', 'index')->name('siswa');
        Route::get('/siswa/create', 'create')->name('siswa.create');
        Route::post('/siswa/save', 'store')->name('siswa.save');
        Route::get('/siswa/edit/{id_siswa}', 'edit')->name('siswa.edit');
        Route::post('/siswa/update/{id_siswa}', 'update')->name('siswa.update');
        Route::delete('/siswa/{id_siswa}', 'destroy')->name('siswa.destroy');
        Route::get('/siswa/cetak', 'pdf')->name('siswa.cetak');
    });
    // Ekstarkulikuler
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/ekskul', 'index')->name('ekskul');
        Route::get('/ekskul/create', 'create')->name('ekskul.create');
        Route::post('/ekskul/save', 'store')->name('ekskul.save');
        Route::get('/ekskul/edit/{id_ekskul}', 'edit')->name('ekskul.edit');
        Route::post('/ekskul/update/{id_ekskul}', 'update')->name('ekskul.update');
        Route::delete('/ekskul/{id_ekskul}', 'destroy')->name('ekskul.destroy');
        Route::get('/ekskul/cetak', 'pdf')->name('ekskul.cetak');
    });
    // Rekrutmen
    Route::controller(DataRekrutmenController::class)->group(function () {
        Route::get('/rekrutmen', 'index')->name('rekrutmen');
        Route::get('/rekrutmen/create', 'create')->name('rekrutmen.create');
        Route::post('/rekrutmen/save', 'store')->name('rekrutmen.save');
        Route::get('/rekrutmen/edit/{id_rekrutmen}', 'edit')->name('rekrutmen.edit');
        Route::put('/rekrutmen/update/{id_rekrutmen}', 'update')->name('rekrutmen.update');
        Route::delete('/rekrutmen/{id_rekrutmen}', 'destroy')->name('rekrutmen.destroy');
        Route::get('/rekrutmen/cetak', 'pdf')->name('rekrutmen.cetak');
    });
    // Pendaftaran
    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/pendaftaran', 'index')->name('pendaftaran');
        Route::get('/pendaftaran/create', 'create')->name('pendaftaran.create');
        Route::post('/pendaftaran/save', 'store')->name('pendaftaran.save');
        Route::get('/pendaftaran/edit/{id_pendaftaran}', 'edit')->name('pendaftaran.edit');
        Route::post('/pendaftaran/update/{id_pendaftaran}', 'update')->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id_pendaftaran}', 'destroy')->name('pendaftaran.destroy');
        Route::get('/pendaftaran/cetak', 'pdf')->name('pendaftaran.cetak');
    });
    // Jadwal Tes
    Route::controller(JadwalTesController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::get('/jadwal/create', 'create')->name('jadwal.create');
        Route::post('/jadwal/save', 'store')->name('jadwal.save');
        Route::get('/jadwal/edit/{id_jadwal}', 'edit')->name('jadwal.edit');
        Route::post('/jadwal/update/{id_jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id_jadwal}', 'destroy')->name('jadwal.destroy');
        Route::get('/jadwal/cetak', 'pdf')->name('jadwal.cetak');
    });
    // Hasil Akhir
    Route::controller(DataHasilTesController::class)->group(function () {
        Route::get('/hasil', 'index')->name('hasil');
        Route::get('/hasil/create', 'create')->name('hasil.create');
        Route::post('/hasil/save', 'store')->name('hasil.save');
        Route::get('/hasil/edit/{id_hasil}', 'edit')->name('hasil.edit');
        Route::post('/hasil/update/{id_hasil}', 'update')->name('hasil.update');
        Route::delete('/hasil/{id_hasil}', 'destroy')->name('hasil.destroy');
        Route::get('/hasil/cetak', 'pdf')->name('hasil.cetak');
    });
    // Pengumuman
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/pengumuman', 'index')->name('pengumuman');
        Route::get('/pengumuman/create', 'create')->name('pengumuman.create');
        Route::post('/pengumuman/save', 'store')->name('pengumuman.save');
        Route::get('/pengumuman/edit/{id_pengumuman}', 'edit')->name('pengumuman.edit');
        Route::post('/pengumuman/update/{id_pengumuman}', 'update')->name('pengumuman.update');
        Route::delete('/pengumuman/{id_pengumuman}', 'destroy')->name('pengumuman.destroy');
        Route::get('/pengumuman/cetak', 'pdf')->name('pengumuman.cetak');
    });
});

//pembina
Route::group(['prefix' => 'pembina', 'as' => 'pembina.'], function () {
    Route::get('/dashbord', [AdminController::class, 'index'])->name('pembina');
    Route::get('/dashbord', [AdminController::class, 'index'])->name('pembina');
    Route::get('/dashbord', [AdminController::class, 'index'])->name('pembina');
    Route::get('/dashbord', [AdminController::class, 'index'])->name('pembina');
    // Route Resource
});

//siswa
Route::group(['prefix' => 'siswa', 'as' => 'siswa.'], function () {
    Route::get('/dashbord', [AdminController::class, 'index'])->name('siswa');

    // Route Resource
});
