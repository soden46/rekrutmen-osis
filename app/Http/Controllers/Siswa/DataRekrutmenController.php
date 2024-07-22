<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DokumenPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
    public function daftar(Request $request, $id_rekrutmen)
    {
        // Validasi input
        // dd($request->file('kartu_pelajar'));
        // $request->validate([
        //     'kartu_pelajar' => 'required|file|mimes:pdf',
        //     'pas_foto' => 'required|file|image',
        //     'surat_izin' => 'required|file|mimes:pdf',
        // ]);


        try {
            DB::transaction(function () use ($request, $id_rekrutmen) {
                // Mendapatkan pengguna yang sedang login
                $user = Auth::user();
                $siswa = SiswaModel::where('id_user', $user->id)->first();

                // Pengecekan apakah siswa sudah mendaftar pada ekskul yang sama
                $existingPendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)
                    ->where('id_rekrutmen', $id_rekrutmen)
                    ->first();

                if ($existingPendaftaran) {
                    throw new \Exception('Anda sudah mendaftar untuk ekskul ini');
                }

                // Logika untuk menyimpan data pendaftaran
                $pendaftaran = DataPendaftaran::create([
                    'id_siswa' => $siswa->id_siswa,
                    'id_rekrutmen' => $id_rekrutmen,
                    'tanggal' => now(),
                    'status' => 'Pending',
                ]);

                // dd($pendaftaran->id);

                // Menyimpan file dokumen
                $files = [
                    'kartu_pelajar' => $request->file('kartu_pelajar'),
                    'pas_foto' => $request->file('pas_foto'),
                    'surat_izin' => $request->file('surat_izin')
                ];

                $storagePath = public_path('dokumen_pendaftaran'); // Lokasi penyimpanan file

                // Membuat direktori jika belum ada
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                foreach ($files as $type => $file) {
                    if ($file) {
                        // Membuat nama file unik
                        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                        $filePath = 'dokumen_pendaftaran/' . $fileName;

                        // Memindahkan file dari direktori sementara ke direktori yang ditentukan
                        $file->move(public_path('dokumen_pendaftaran'), $fileName);

                        // dd($pendaftaran->id);
                        DokumenPendaftaran::create([
                            'id_pendaftaran' => $pendaftaran->id,
                            'path' => $filePath, // Simpan path relatif
                            'type' => $type,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

            return redirect()->route('siswa.rekrutmen')->with('success', 'Pendaftaran berhasil');

        } catch (\Exception $e) {
            // Handle exception and redirect back with error message
            return redirect()->route('siswa.rekrutmen')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
