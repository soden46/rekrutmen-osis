<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\DokumenPendaftaran;
use App\Models\rekrutmenModel;
use App\Models\SiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOsis(Request $request)
    {
        $cari = $request->cari;

        $pendaftaranQuery = DataPendaftaran::with(['rekrutmen', 'siswa.users', 'dokumen'])
            ->whereHas('rekrutmen', function ($query) {
                $query->whereHas('ekskul', function ($query) {
                    $query->where('nama_ekskul', 'osis');
                });
            });

        if ($cari != NULL) {
            $pendaftaranQuery->where(function ($query) use ($cari) {
                $query->where('tanggal', 'like', "%{$cari}%")
                    ->orWhere('status', 'like', "%{$cari}%")
                    ->orWhereHas('siswa', function ($query) use ($cari) {
                        $query->where('nama_siswa', 'like', "%{$cari}%");
                    });
            });
        }

        $pendaftaran = $pendaftaranQuery->orderBy('rata_rata', 'desc')->paginate(10);

        // Process each pendaftaran to add document paths
        foreach ($pendaftaran as $data) {
            $data->kartuPelajar = $data->dokumen->where('type', 'kartu_pelajar')->first();
            $data->suratIzin = $data->dokumen->where('type', 'surat_izin')->first();
            $data->pasFoto = $data->dokumen->where('type', 'pas_foto')->first();
        }

        return view('admin.pendaftaran.osis.index', [
            'title' => 'Data Pendaftaran',
            'pendaftaran' => $pendaftaran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOsis()
    {
        return view('admin.pendaftaran.osis.create', [
            'title' => 'Tambah Data Pendaftaran',
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOsis(Request $request)
    {
        $validatedData = $request->validate([
            'id_siswa' => 'required',
            'id_rekrutmen' => 'required',
            'tanggal' => 'required',
            'nilai_tertulis' => 'nullable',
            'nilai_wawancara' => 'nullable',
            'rata_rata' => 'nullable',
            'status' => 'required',
        ]);

        try {
            DataPendaftaran::create($validatedData);
            return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.osis')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function editOsis(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        $dokumen = DokumenPendaftaran::all()->where('id_pendaftaran', $id_pendaftaran)->groupBy('type');
        return view('admin.pendaftaran.osis.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->where('id_pendaftaran', $id_pendaftaran)->first(),
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get(),
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function updateOsis(Request $request, $id_pendaftaran)
    {
        $rules = [
            'id_siswa' => 'nullable',
            'id_rekrutmen' => 'nullable',
            'tanggal' => 'nullable',
            'nilai_tertulis' => 'nullable',
            'nilai_wawancara' => 'nullable',
            'rata_rata' => 'nullable',
            'status' => 'nullable',
        ];

        $validatedData = $request->validate($rules);

        try {
            DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);
            return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.osis')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroyOsis($id_pendaftaran)
    {
        try {
            DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->delete();
            return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.osis')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
    }

    public function pdfOsis()
    {
        $data = [
            'title' => 'Data Pendaftaran Osis',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')
                ->whereHas('rekrutmen', function ($query) {
                    $query->whereHas('ekskul', function ($query) {
                        $query->where('nama_ekskul', 'osis');
                    });
                })
                ->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.pendaftaran', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-pendaftaran.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTonti(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('admin.pendaftaran.tonti.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')
                    ->where(function ($query) use ($cari) {
                        $query->where('tanggal', 'like', "%{$cari}%")
                            ->orWhere('status', 'like', "%{$cari}%")
                            ->orWhereHas('siswa', function ($query) use ($cari) {
                                $query->where('nama_siswa', 'like', "%{$cari}%");
                            });
                    })
                    ->whereHas('rekrutmen', function ($query) {
                        $query->whereHas('ekskul', function ($query) {
                            $query->where('nama_ekskul', 'tonti');
                        });
                    })
                    ->orderBy('nilai_seleksi_latihan_tonti', 'desc')
                    ->paginate(10),
            ]);
        } else {
            return view('admin.pendaftaran.tonti.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->orderBy('nilai_seleksi_latihan_tonti', 'desc')->paginate(10),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTonti()
    {
        return view('admin.pendaftaran.tonti.create', [
            'title' => 'Tambah Data Pendaftaran',
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTonti(Request $request)
    {
        $validatedData = $request->validate([
            'id_siswa' => 'required',
            'id_rekrutmen' => 'required',
            'tanggal' => 'required',
            'nilai_seleksi_latihan_tonti' => 'nullable',
            'status' => 'required',
        ]);

        try {
            DataPendaftaran::create($validatedData);
            return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.tonti')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function editTonti(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        $dokumen = DokumenPendaftaran::all()->where('id_pendaftaran', $id_pendaftaran)->groupBy('type');
        return view('admin.pendaftaran.tonti.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->where('id_pendaftaran', $id_pendaftaran)->first(),
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get(),
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function updateTonti(Request $request, $id_pendaftaran)
    {
        $rules = [
            'id_siswa' => 'nullable',
            'id_rekrutmen' => 'nullable',
            'tanggal' => 'nullable',
            'nilai_seleksi_latihan_tonti' => 'nullable',
            'status' => 'nullable',
        ];

        $validatedData = $request->validate($rules);

        try {
            DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);
            return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.tonti')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroyTonti($id_pendaftaran)
    {
        try {
            DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->delete();
            return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pendaftaran.tonti')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
    }

    public function pdfTonti()
    {

        $pendaftaran = DataPendaftaran::with('rekrutmen.ekskul', 'siswa.users')->get();

        // Pastikan bahwa pendaftaran tidak null atau kosong
        if ($pendaftaran->isEmpty()) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }

        $data = [
            'title' => 'Data Pendaftaran',
            'pendaftaran' => $pendaftaran,
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.pendaftaran', $data)->setPaper($customPaper, 'portrait');

        return $pdf->stream('data-pendaftaran.pdf');
    }
}
