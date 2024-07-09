<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailUndanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataEkskulController;
use App\Http\Controllers\Admin\DataHasilTesController;
use App\Http\Controllers\Admin\DataPembinaController;
use App\Http\Controllers\Admin\DataRekrutmenController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\JadwalTesController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Pembina\DataEkskulController as PembinaDataEkskulController;
use App\Http\Controllers\Pembina\DataHasilTesController as PembinaDataHasilTesController;
use App\Http\Controllers\Pembina\DataPendaftaranController;
use App\Http\Controllers\Pembina\DataRekrutmenController as PembinaDataRekrutmenController;
use App\Http\Controllers\Pembina\DataSiswaController as PembinaDataSiswaController;
use App\Http\Controllers\Pembina\JadwalTesController as PembinaJadwalTesController;
use App\Http\Controllers\Pembina\PembinaController;
use App\Http\Controllers\Siswa\DataHasilTesController as SiswaDataHasilTesController;
use App\Http\Controllers\Siswa\DataJadwalTesController;
use App\Http\Controllers\Siswa\DataPendaftaranController as SiswaDataPendaftaranController;
use App\Http\Controllers\Siswa\DataRekrutmenController as SiswaDataRekrutmenController;
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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

//admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashbord', [AdminController::class, 'index'])->name('index');
    // Admin
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'admin')->name('admin');
        Route::get('/admin/create', 'create')->name('admin.create');
        Route::post('/admin/save', 'store')->name('admin.save');
        Route::get('/admin/edit/{id_admin}', 'edit')->name('admin.edit');
        Route::put('/admin/update/{id_admin}', 'update')->name('admin.update');
        Route::delete('/admin/destroy/{id_admin}', 'destroy')->name('admin.destroy');
        Route::get('/admin/cetak', 'pdf')->name('admin.cetak');
    });
    // Pembina
    Route::controller(DataPembinaController::class)->group(function () {
        Route::get('/pembina', 'index')->name('pembina');
        Route::get('/pembina/create', 'create')->name('pembina.create');
        Route::post('/pembina/save', 'store')->name('pembina.save');
        Route::get('/pembina/edit/{id_pembina}', 'edit')->name('pembina.edit');
        Route::put('/pembina/update/{id_pembina}', 'update')->name('pembina.update');
        Route::delete('/pembina/{id_pembina}', 'destroy')->name('pembina.destroy');
        Route::get('/pembina/cetak', 'pdf')->name('pembina.cetak');
    });
    // Siswa
    Route::controller(DataSiswaController::class)->group(function () {
        Route::get('/siswa', 'index')->name('siswa');
        Route::get('/siswa/create', 'create')->name('siswa.create');
        Route::post('/siswa/save', 'store')->name('siswa.save');
        Route::get('/siswa/edit/{id_siswa}', 'edit')->name('siswa.edit');
        Route::put('/siswa/update/{id_siswa}', 'update')->name('siswa.update');
        Route::delete('/siswa/{id_siswa}', 'destroy')->name('siswa.destroy');
        Route::get('/siswa/cetak', 'pdf')->name('siswa.cetak');
    });
    // Ekstarkulikuler
    Route::controller(DataEkskulController::class)->group(function () {
        Route::get('/ekskul', 'index')->name('ekskul');
        Route::get('/ekskul/create', 'create')->name('ekskul.create');
        Route::post('/ekskul/save', 'store')->name('ekskul.save');
        Route::get('/ekskul/edit/{id_ekskul}', 'edit')->name('ekskul.edit');
        Route::put('/ekskul/update/{id_ekskul}', 'update')->name('ekskul.update');
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
    // Pendaftaran Osis
    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/pendaftaran-osis', 'indexOsis')->name('pendaftaran.osis');
        Route::get('/pendaftaran-osis/create', 'createOsis')->name('pendaftaran.osis.create');
        Route::post('/pendaftaran-osis/save', 'storeOsis')->name('pendaftaran.osis.save');
        Route::get('/pendaftaran-osis/edit/{id_pendaftaran}', 'editOsis')->name('pendaftaran.osis.edit');
        Route::put('/pendaftaran-osis/update/{id_pendaftaran}', 'updateOsis')->name('pendaftaran.osis.update');
        Route::delete('/pendaftaran-osis/{id_pendaftaran}', 'destroyOsis')->name('pendaftaran.osis.destroy');
        Route::get('/pendaftaran-osis/cetak', 'pdfOsis')->name('pendaftaran.osis.cetak');
    });
    // Pendaftaran Tonti
    Route::controller(PendaftaranController::class)->group(function () {
        Route::get('/pendaftaran-tonti', 'indexTonti')->name('pendaftaran.tonti');
        Route::get('/pendaftaran-tonti/create', 'createTonti')->name('pendaftaran.tonti.create');
        Route::post('/pendaftaran-tonti/save', 'storeTonti')->name('pendaftaran.tonti.save');
        Route::get('/pendaftaran-tonti/edit/{id_pendaftaran}', 'editTonti')->name('pendaftaran.tonti.edit');
        Route::put('/pendaftaran-tonti/update/{id_pendaftaran}', 'updateTonti')->name('pendaftaran.tonti.update');
        Route::delete('/pendaftaran-tonti/{id_pendaftaran}', 'destroyTonti')->name('pendaftaran.tonti.destroy');
        Route::get('/pendaftaran-tonti/cetak', 'pdfTonti')->name('pendaftaran.tonti.cetak');
    });
    // Jadwal Tes
    Route::controller(JadwalTesController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::get('/jadwal/create', 'create')->name('jadwal.create');
        Route::post('/jadwal/save', 'store')->name('jadwal.save');
        Route::get('/jadwal/edit/{id_jadwal}', 'edit')->name('jadwal.edit');
        Route::put('/jadwal/update/{id_jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id_jadwal}', 'destroy')->name('jadwal.destroy');
        Route::get('/jadwal/cetak', 'pdf')->name('jadwal.cetak');
    });
    // Hasil Akhir
    Route::controller(DataHasilTesController::class)->group(function () {
        Route::get('/hasil', 'index')->name('hasil');
        Route::get('/hasil/create', 'create')->name('hasil.create');
        Route::post('/hasil/save', 'store')->name('hasil.save');
        Route::get('/hasil/edit/{id_hasil}', 'edit')->name('hasil.edit');
        Route::put('/hasil/update/{id_hasil}', 'update')->name('hasil.update');
        Route::delete('/hasil/{id_hasil}', 'destroy')->name('hasil.destroy');
        Route::get('/hasil/cetak', 'pdf')->name('hasil.cetak');
    });
});

//pembina
Route::group(['prefix' => 'pembina', 'as' => 'pembina.'], function () {
    Route::get('/dashbord', [PembinaController::class, 'index'])->name('index');

    // Siswa
    Route::controller(PembinaDataSiswaController::class)->group(function () {
        Route::get('/siswa', 'index')->name('siswa');
        Route::get('/siswa/create', 'create')->name('siswa.create');
        Route::post('/siswa/save', 'store')->name('siswa.save');
        Route::get('/siswa/edit/{id_siswa}', 'edit')->name('siswa.edit');
        Route::put('/siswa/update/{id_siswa}', 'update')->name('siswa.update');
        Route::delete('/siswa/{id_siswa}', 'destroy')->name('siswa.destroy');
        Route::get('/siswa/cetak', 'pdf')->name('siswa.cetak');
    });
    // Rekrutmen
    Route::controller(PembinaDataRekrutmenController::class)->group(function () {
        Route::get('/rekrutmen', 'index')->name('rekrutmen');
        Route::get('/rekrutmen/create', 'create')->name('rekrutmen.create');
        Route::post('/rekrutmen/save', 'store')->name('rekrutmen.save');
        Route::get('/rekrutmen/edit/{id_rekrutmen}', 'edit')->name('rekrutmen.edit');
        Route::put('/rekrutmen/update/{id_rekrutmen}', 'update')->name('rekrutmen.update');
        Route::delete('/rekrutmen/{id_rekrutmen}', 'destroy')->name('rekrutmen.destroy');
        Route::get('/rekrutmen/cetak', 'pdf')->name('rekrutmen.cetak');
    });
    // Pendaftaran
    Route::controller(DataPendaftaranController::class)->group(function () {
        Route::get('/pendaftaran', 'index')->name('pendaftaran');
        Route::get('/pendaftaran/create', 'create')->name('pendaftaran.create');
        Route::post('/pendaftaran/save', 'store')->name('pendaftaran.save');
        Route::get('/pendaftaran/edit/{id_pendaftaran}', 'edit')->name('pendaftaran.edit');
        Route::put('/pendaftaran/update/{id_pendaftaran}', 'update')->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id_pendaftaran}', 'destroy')->name('pendaftaran.destroy');
        Route::get('/pendaftaran/cetak', 'pdf')->name('pendaftaran.cetak');
    });
    // Jadwal Tes
    Route::controller(PembinaJadwalTesController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::get('/jadwal/create', 'create')->name('jadwal.create');
        Route::post('/jadwal/save', 'store')->name('jadwal.save');
        Route::get('/jadwal/edit/{id_jadwal}', 'edit')->name('jadwal.edit');
        Route::put('/jadwal/update/{id_jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id_jadwal}', 'destroy')->name('jadwal.destroy');
        Route::get('/jadwal/cetak', 'pdf')->name('jadwal.cetak');
    });
    // Hasil Akhir
    Route::controller(PembinaDataHasilTesController::class)->group(function () {
        Route::get('/hasil', 'index')->name('hasil');
        Route::get('/hasil/create', 'create')->name('hasil.create');
        Route::post('/hasil/save', 'store')->name('hasil.save');
        Route::get('/hasil/edit/{id_hasil}', 'edit')->name('hasil.edit');
        Route::put('/hasil/update/{id_hasil}', 'update')->name('hasil.update');
        Route::delete('/hasil/{id_hasil}', 'destroy')->name('hasil.destroy');
        Route::get('/hasil/cetak', 'pdf')->name('hasil.cetak');
    });
});

//siswa
Route::group(['prefix' => 'siswa', 'as' => 'siswa.'], function () {
    Route::get('/dashbord', [SiswaController::class, 'index'])->name('index');
    Route::get('/profile', [SiswaController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [SiswaController::class, 'storeProfile'])->name('profile.update');

    // Rekrutmen
    Route::controller(SiswaDataRekrutmenController::class)->group(function () {
        Route::get('/rekrutmen', 'index')->name('rekrutmen');
        Route::post('/rekrutmen/daftar/{id_rekrutmen}', 'daftar')->name('rekrutmen.daftar');
    });
    // Pendaftaran
    Route::controller(SiswaDataPendaftaranController::class)->group(function () {
        Route::get('/pendaftaran', 'index')->name('pendaftaran');
        Route::get('/pendaftaran/create', 'create')->name('pendaftaran.create');
        Route::post('/pendaftaran/save', 'store')->name('pendaftaran.save');
        Route::get('/pendaftaran/edit/{id_pendaftaran}', 'edit')->name('pendaftaran.edit');
        Route::put('/pendaftaran/update/{id_pendaftaran}', 'update')->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id_pendaftaran}', 'destroy')->name('pendaftaran.destroy');
        Route::get('/pendaftaran/cetak', 'pdf')->name('pendaftaran.cetak');
    });
    // Jadwal Tes
    Route::controller(DataJadwalTesController::class)->group(function () {
        Route::get('/jadwal', 'index')->name('jadwal');
        Route::get('/jadwal/create', 'create')->name('jadwal.create');
        Route::post('/jadwal/save', 'store')->name('jadwal.save');
        Route::get('/jadwal/edit/{id_jadwal}', 'edit')->name('jadwal.edit');
        Route::put('/jadwal/update/{id_jadwal}', 'update')->name('jadwal.update');
        Route::delete('/jadwal/{id_jadwal}', 'destroy')->name('jadwal.destroy');
        Route::get('/jadwal/cetak', 'pdf')->name('jadwal.cetak');
    });
    // Hasil Akhir
    Route::controller(SiswaDataHasilTesController::class)->group(function () {
        Route::get('/hasil', 'index')->name('hasil');
        Route::get('/hasil/create', 'create')->name('hasil.create');
        Route::post('/hasil/save', 'store')->name('hasil.save');
        Route::get('/hasil/edit/{id_hasil}', 'edit')->name('hasil.edit');
        Route::put('/hasil/update/{id_hasil}', 'update')->name('hasil.update');
        Route::delete('/hasil/{id_hasil}', 'destroy')->name('hasil.destroy');
        Route::get('/hasil/cetak', 'pdf')->name('hasil.cetak');
    });
});
