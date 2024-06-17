<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\HasilPenerimaan;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataHasilTesController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $user = Auth::user();
        $siswa = SiswaModel::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Siswa tidak ditemukan');
        }

        $siswaId = $siswa->id_siswa;

        // Ambil ID pendaftaran berdasarkan id_siswa
        $pendaftaranIds = DataPendaftaran::where('id_siswa', $siswaId)->pluck('id_pendaftaran');

        $query = HasilPenerimaan::with('pendaftaran', 'pendaftaran.siswa')
            ->whereIn('id_pendaftaran', $pendaftaranIds);

        if ($cari) {
            $query->where(function ($query) use ($cari) {
                $query->where('nama_tes', 'like', "%{$cari}%")
                    ->orWhere('status', 'like', "%{$cari}%")
                    ->orWhereHas('pendaftaran', function ($query) use ($cari) {
                        $query->where('tanggal', 'like', "%{$cari}%");
                    });
            });
        }

        $hasil = $query->paginate(10);

        return view('siswa.hasil.index', [
            'title' => 'Data Hasil Akhir',
            'hasil' => $hasil,
            'pendaftaran' => DataPendaftaran::where('id_siswa', $siswaId)->get(),
        ]);
    }
}
