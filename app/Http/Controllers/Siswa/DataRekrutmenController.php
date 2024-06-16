<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
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

        // Logika untuk menyimpan data pendaftaran
        DataPendaftaran::create([
            'user_id' => $user->id,
            'id_rekrutmen' => $id_rekrutmen,
        ]);

        return redirect()->route('siswa.rekrutmen')->with('success', 'Pendaftaran berhasil');
    }
}
