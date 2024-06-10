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
    public function index(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('admin.pendaftaran.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')
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
            return view('admin.pendaftaran.index', [
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
    public function create()
    {
        return view('admin.pendaftaran.create', [
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
    public function store(Request $request)
    {
        // dd($request);

        $validatedData = $request->validate([
            'id_siswa' => 'required',
            'id_rekrutmen' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
        ]);

        // dd($validatedData);
        DataPendaftaran::create($validatedData);

        return redirect()->route('admin.pendaftaran')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        return view('admin.pendaftaran.edit', [
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
    public function update(Request $request, $id_pendaftaran)
    {
        $rules = [
            'id_rekrutmen' => 'required',
            'nama_lowongan' => 'required|max:255',
            'tanggal_dimulai' => 'required',
            'tanggal_berakhir' => 'required',
            'deskripsi' => 'required',
        ];


        $validatedData = $request->validate($rules);

        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);

        return redirect()->route('admin.pendaftaran')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pendaftaran)
    {
        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->delete();
        return redirect()->route('admin.pendaftaran')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.pendaftaran', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-pendaftaran.pdf');
    }
}
