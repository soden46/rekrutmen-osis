<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\HasilPenerimaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DataHasilTesController extends Controller
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
            return view('admin.hasil.index', [
                'title' => 'Data Hasil Tes',
                'hasil' => HasilPenerimaan::with('pendaftaran')
                    ->where(function ($query) use ($cari) {
                        $query->where('nama_tes', 'like', "%{$cari}%")
                            ->orWhere('status', 'like', "%{$cari}%")
                            ->orWhereHas('pendaftaran', function ($query) use ($cari) {
                                $query->where('tanggal', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'pendaftaran' => DataPendaftaran::get(),
            ]);
        } else {
            return view('admin.hasil.index', [
                'title' => 'Data Hasil Tes',
                'hasil' => HasilPenerimaan::with('pendaftaran')->paginate(10),
                'pendaftaran' => DataPendaftaran::get(),

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
        return view('admin.hasil.create', [
            'title' => 'Tambah Data Hasil Tes',
            'pendaftaran' => DataPendaftaran::get()

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
            'id_pendaftaran' => 'required',
            'nama_tes' => 'required|max:255',
            'skor_final' => 'required',
            'status' => 'required',
        ]);

        // dd($validatedData);
        HasilPenerimaan::create($validatedData);

        return redirect()->route('admin.hasil')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(HasilPenerimaan $hasil, $id_hasil)
    {
        return view('admin.hasil.edit', [
            'title' => 'Edit Data Hasil Tes',
            'hasil' => HasilPenerimaan::with('pendaftaran')->where('id_hasil', $id_hasil)->first(),
            'pendaftaran' => DataPendaftaran::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_hasil)
    {
        $rules = [
            'id_pendaftaran' => 'required',
            'nama_tes' => 'required|max:255',
            'skor_final' => 'required',
            'status' => 'required',
        ];


        $validatedData = $request->validate($rules);

        HasilPenerimaan::where('id_hasil', $id_hasil)->update($validatedData);

        return redirect()->route('admin.hasil')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_hasil)
    {
        HasilPenerimaan::where('id_hasil', $id_hasil)->delete();
        return redirect()->route('admin.hasil')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Hasil Tes',
            'hasil' => HasilPenerimaan::with('pendaftaran')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.hasil', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('surat-keterangan-biasa.pdf');
    }
}
