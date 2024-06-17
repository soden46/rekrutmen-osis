<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari;

        $user = Auth::user();
        $siswa = SiswaModel::where('id_user', $user->id)->first();
        $siswaId = $siswa->id_siswa;

        if ($cari != NULL) {
            return view('siswa.pendaftaran.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                    ->whereHas('rekrutmen.ekskul', function ($query) use ($siswaId) {
                        $query->where('id_siswa', $siswaId);
                    })
                    ->where(function ($query) use ($cari) {
                        $query->where('tanggal', 'like', "%{$cari}%")
                            ->orWhere('status', 'like', "%{$cari}%")
                            ->orWhereHas('siswa', function ($query) use ($cari) {
                                $query->where('nama_siswa', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
            ]);
        } else {
            return view('siswa.pendaftaran.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                    ->whereHas('rekrutmen.ekskul', function ($query) use ($siswaId) {
                        $query->where('id_siswa', $siswaId);
                    })->paginate(10),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        $user = Auth::user();
        $siswa = SiswaModel::where('id_user', $user->id)->first();
        $siswaId = $siswa->id_siswa;

        return view('siswa.pendaftaran.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                ->whereHas('rekrutmen.ekskul', function ($query) use ($siswaId) {
                    $query->where('id_siswa', $siswaId);
                })->where('id_pendaftaran', $id_pendaftaran)->first(),
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get()
        ]);
    }
}
