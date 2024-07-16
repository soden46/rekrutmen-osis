<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
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

        if ($cari != NULL) {
            return view('admin.pendaftaran.osis.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')
                    ->where(function ($query) use ($cari) {
                        $query->where('tanggal', 'like', "%{$cari}%")
                            ->orWhere('status', 'like', "%{$cari}%")
                            ->orWhereHas('siswa', function ($query) use ($cari) {
                                $query->where('nama_siswa', 'like', "%{$cari}%");
                            });
                    })->whereHas('rekrutmen', function ($query) {
                        $query->whereHas('ekskul', function ($query) {
                            $query->where('nama_ekskul', 'osis');
                        });
                    })
                    ->paginate(10),
            ]);
        } else {
            return view('admin.pendaftaran.osis.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')
                    ->whereHas('rekrutmen', function ($query) {
                        $query->whereHas('ekskul', function ($query) {
                            $query->where('nama_ekskul', 'osis');
                        });
                    })
                    ->paginate(10),
            ]);
        }
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
        // dd($request);

        $validatedData = $request->validate([
            'id_siswa' => 'required',
            'id_rekrutmen' => 'required',
            'tanggal' => 'required',
            'nilai_tertulis' => 'nullable',
            'nilai_wawancara' => 'nullable',
            'rata_rata' => 'nullable',
            'status' => 'required',
        ]);

        // dd($validatedData);
        DataPendaftaran::create($validatedData);

        return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function editOsis(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        return view('admin.pendaftaran.osis.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->where('id_pendaftaran', $id_pendaftaran)->first(),
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get()
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

        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);

        return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroyOsis($id_pendaftaran)
    {
        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->delete();
        return redirect()->route('admin.pendaftaran.osis')->with('success', 'Data has ben deleted');
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
                    ->paginate(10),
            ]);
        } else {
            return view('admin.pendaftaran.tonti.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->paginate(10),
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
        // dd($request);

        $validatedData = $request->validate([
            'id_siswa' => 'required',
            'id_rekrutmen' => 'required',
            'tanggal' => 'required',
            'nilai_seleksi_latihan_tonti' => 'nullable',
            'status' => 'required',
        ]);

        // dd($validatedData);
        DataPendaftaran::create($validatedData);

        return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function editTonti(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        return view('admin.pendaftaran.tonti.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->where('id_pendaftaran', $id_pendaftaran)->first(),
            'rekrutmen' => DataRekrutmen::get(),
            'siswa' => SiswaModel::get()
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

        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);

        return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroyTonti($id_pendaftaran)
    {
        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->delete();
        return redirect()->route('admin.pendaftaran.tonti')->with('success', 'Data has ben deleted');
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
