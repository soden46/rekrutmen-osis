<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
use App\Models\HasilPenerimaan;
use App\Models\PembinaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembinaController extends Controller
{
    public function index()
    {
        // Mendapatkan id pembina yang sedang login
        $user = Auth::user();

        $pembina = PembinaModel::where('id_user', $user->id)->first();

        // Mendapatkan id ekstrakurikuler dari pembina yang sedang login
        $Eksekul = EkskulModel::where('id_pembina', $pembina->id_pembina)->first();
        // dd($Eksekul);
        $idEkstrakurikuler = $Eksekul->id_ekskul;

        // Mendapatkan ekskul yang diasuh oleh pembina
        $ekskuls = EkskulModel::where('id_pembina', $pembina->id_pembina)->get();

        // Hitung jumlah rekrutmen berdasarkan ekstrakurikuler pembina
        $jumlahRekrutmen = DataRekrutmen::where('id_ekskul', $idEkstrakurikuler)->count();

        // Menyiapkan array untuk menyimpan jumlah pendaftar per ekskul
        $jumlahPendaftar = [];

        // Menghitung jumlah pendaftar untuk setiap ekskul yang diasuh pembina
        foreach ($ekskuls as $ekskul) {
            $jumlahPendaftar[$ekskul->nama_ekskul] = DataPendaftaran::whereHas('rekrutmen', function ($query) use ($ekskul) {
                $query->where('id_ekskul', $ekskul->id_ekskul);
            })->distinct('id_pendaftaran')->count('id_pendaftaran');
        }

        return view('pembina.index', [
            'jumlahRekrutmen' => $jumlahRekrutmen,
            'jumlahPendaftar' => $jumlahPendaftar,
        ]);
    }
}
