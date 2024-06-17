<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
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

        // Hitung jumlah rekrutmen berdasarkan ekstrakurikuler pembina
        $jumlahRekrutmen = DataRekrutmen::where('id_ekskul', $idEkstrakurikuler)->count();

        // Hitung jumlah pendaftar berdasarkan ekstrakurikuler pembina
        $jumlahPendaftar = HasilPenerimaan::whereHas('pendaftaran', function ($query) use ($idEkstrakurikuler) {
            $query->whereHas('rekrutmen', function ($query) use ($idEkstrakurikuler) {
                $query->where('id_ekskul', $idEkstrakurikuler);
            });
        })->distinct('id_pendaftaran')->count('id_pendaftaran');

        return view('pembina.index', [
            'jumlahRekrutmen' => $jumlahRekrutmen,
            'jumlahPendaftar' => $jumlahPendaftar,
        ]);
    }
}
