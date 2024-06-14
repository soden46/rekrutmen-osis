<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembinaController extends Controller
{
    public function index()
    {
        // Mendapatkan id pembina yang sedang login
        $pembina = Auth::user()->pembina;

        // Jika pembina tidak ditemukan atau tidak memiliki ekstrakurikuler, mungkin ada penanganan khusus yang perlu dilakukan di sini.

        // Mendapatkan id ekstrakurikuler dari pembina yang sedang login
        $idEkstrakurikuler = $pembina->ekstrakurikuler->id_ekstrakurikuler;

        // Hitung jumlah rekrutmen berdasarkan ekstrakurikuler pembina
        $jumlahRekrutmen = DataRekrutmen::where('id_ekstrakurikuler', $idEkstrakurikuler)->count();

        // Hitung jumlah pendaftar berdasarkan ekstrakurikuler pembina
        $jumlahPendaftar = HasilPenerimaan::whereHas('pendaftaran', function ($query) use ($idEkstrakurikuler) {
            $query->whereHas('rekrutmen', function ($query) use ($idEkstrakurikuler) {
                $query->where('id_ekstrakurikuler', $idEkstrakurikuler);
            });
        })->distinct('id_pendaftaran')->count('id_pendaftaran');

        return view('pembina.index', [
            'jumlahRekrutmen' => $jumlahRekrutmen,
            'jumlahPendaftar' => $jumlahPendaftar,
        ]);
    }
}
