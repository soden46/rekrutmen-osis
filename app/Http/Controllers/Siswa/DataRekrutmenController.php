<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataRekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari;

        // Mendapatkan pengguna yang sedang login
        $user = Auth::user()->id;
        if ($cari != NULL) {
            return view('siswa.rekrutmen.index', [
                'title' => 'Data Rekrutmen',
                'rekrutmen' => DataRekrutmen::with('ekskul')
                    ->where(function ($query) use ($cari) {
                        $query->where('nama_lowongan', 'like', "%{$cari}%")
                            ->orWhereHas('ekstrakulikuler', function ($query) use ($cari) {
                                $query->where('nama_ekskul', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'ekskul' => EkskulModel::get(),
            ]);
        } else {
            return view('siswa.rekrutmen.index', [
                'title' => 'Data Rekrutmen',
                'rekrutmen' => DataRekrutmen::with('ekskul')->paginate(10),
                'ekskul' => EkskulModel::get(),

            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa.rekrutmen.create', [
            'title' => 'Tambah Data Rekrutmen',
            'ekskul' => EkskulModel::get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function daftar($id_rekrutmen)
    {
        $user = Auth::user();
        $siswa = SiswaModel::where('id_user', $user->id)->first();

        // Pengecekan apakah siswa sudah mendaftar pada ekskul yang sama
        $existingPendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)
            ->where('id_rekrutmen', $id_rekrutmen) // atau ganti 'id_rekrutmen' dengan 'id_ekskul' jika perlu
            ->first();

        if ($existingPendaftaran) {
            return redirect()->route('siswa.rekrutmen')->with('error', 'Anda sudah mendaftar untuk ekskul ini');
        }

        // Logika untuk menyimpan data pendaftaran
        DataPendaftaran::create([
            'id_siswa' => $siswa->id_siswa,
            'id_rekrutmen' => $id_rekrutmen, // atau ganti 'id_rekrutmen' dengan 'id_ekskul' jika perlu
            'tanggal' => now(),
            'status' => 'Pending',
        ]);

        return redirect()->route('siswa.rekrutmen')->with('success', 'Pendaftaran berhasil');
    }
}
