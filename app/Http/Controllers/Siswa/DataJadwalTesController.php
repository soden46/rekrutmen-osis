<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataJadwaltes;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataJadwalTesController extends Controller
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

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Siswa tidak ditemukan');
        }

        $siswaId = $siswa->id_siswa;

        // Ambil ID rekrutmen dari tabel pendaftaran berdasarkan id_siswa
        $rekrutmenIds = DataPendaftaran::where('id_siswa', $siswaId)->pluck('id_rekrutmen');

        $query = DataJadwaltes::with('rekrutmen', 'rekrutmen.ekskul')
            ->whereIn('id_rekrutmen', $rekrutmenIds);

        if ($cari) {
            $query->where(function ($query) use ($cari) {
                $query->where('nama_jadwal_tes', 'like', "%{$cari}%")
                    ->orWhere('tanggal', 'like', "%{$cari}%")
                    ->orWhereHas('rekrutmen', function ($query) use ($cari) {
                        $query->where('nama_lowongan', 'like', "%{$cari}%");
                    });
            });
        }

        $tes = $query->paginate(10);

        return view('siswa.jadwal.index', [
            'title' => 'Data Jadwal Tes',
            'tes' => $tes,
            'rekrutmen' => DataRekrutmen::get(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('siswa.jadwal.create', [
            'title' => 'Tambah Data Jadwal Tes',
            'rekrutmen' => DataRekrutmen::get()

        ]);
    }
}
