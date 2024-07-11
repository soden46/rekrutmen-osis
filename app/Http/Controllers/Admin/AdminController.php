<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
use App\Models\HasilPenerimaan;
use App\Models\PembinaModel;
use App\Models\SiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung jumlah rekrutmen
        $jumlahRekrutmen = DataRekrutmen::count();

        // Menghitung jumlah pendaftar Osis
        $jumlahPendaftarOsis = DataPendaftaran::whereHas('rekrutmen', function ($query) {
            $query->whereHas('ekskul', function ($query) {
                $query->where('nama_ekskul', 'osis');
            });
        })->distinct('id_pendaftaran')->count('id_pendaftaran');

        // Menghitung jumlah pendaftar Tonti
        $jumlahPendaftarTonti = DataPendaftaran::whereHas('rekrutmen', function ($query) {
            $query->whereHas('ekskul', function ($query) {
                $query->where('nama_ekskul', 'tonti');
            });
        })->distinct('id_pendaftaran')->count('id_pendaftaran');

        // Menghitung jumlah ekstrakurikuler
        $jumlahEkstrakurikuler = EkskulModel::count();

        // Menghitung jumlah siswa
        $jumlahSiswa = SiswaModel::count();

        // Menghitung jumlah pembina
        $jumlahPembina = PembinaModel::count();

        return view('admin.index', [
            'jumlahRekrutmen' => $jumlahRekrutmen,
            'jumlahPendaftarOsis' => $jumlahPendaftarOsis,
            'jumlahPendaftarTonti' => $jumlahPendaftarTonti,
            'jumlahEkstrakurikuler' => $jumlahEkstrakurikuler,
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahPembina' => $jumlahPembina,
        ]);
    }

    public function admin()
    {
        $user = Auth::user();
        $admin = AdminModel::with('users')->where('id_user', $user->id)->paginate(10);

        return view('admin.admin.index', [
            'admin' => $admin
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create', [
            'title' => 'Tambah Data Admin',
            'user' => User::where('role', 'admin')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $ValidatedData = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|unique:admin',
            'password' => 'required|min:6|max:12',
        ]);

        // Menyimpan data ke database
        $userID = User::create([
            'nama' => $ValidatedData['nama'],
            'userName' => $ValidatedData['nip'],
            'password' => Hash::make($ValidatedData['password']),
            'role' => 'pembina',
        ]);

        AdminModel::create([
            'id_user' => $userID->id,
            'nip' => $ValidatedData['nip'],
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('admin.admin')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminModel $admin, $id_admin)
    {
        return view('admin.admin.edit', [
            'title' => 'Edit Data Admin',
            'admin' => AdminModel::with('users')->where('id_admin', $id_admin)->first(),
            'user' => User::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_admin)
    {
        $rules = [
            'id_user' => 'max:255',
            'nip' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'date|max:255',
            'jenis_kelamin' => 'max:255',
        ];


        $validatedData = $request->validate($rules);

        AdminModel::where('id_admin', $id_admin)->update($validatedData);

        return redirect()->route('admin.admin')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_admin)
    {
        AdminModel::where('id_admin', $id_admin)->delete();
        return redirect()->route('admin.admin')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Admin',
            'admin' => AdminModel::with('users')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.admin', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-admin.pdf');
    }
}
