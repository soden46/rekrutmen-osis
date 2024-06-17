<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataRekrutmen;
use App\Models\EkskulModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

        if ($cari != NULL) {
            return view('admin.rekrutmen.index', [
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
            return view('admin.rekrutmen.index', [
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
        return view('admin.rekrutmen.create', [
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
    public function store(Request $request)
    {
        // dd($request);

        $validatedData = $request->validate([
            'id_ekskul' => 'required|max:20',
            'nama_lowongan' => 'required|max:20',
            'tanggal_dimulai' => 'required',
            'tanggal_berakhir' => 'required',
            'deskripsi' => 'required',
        ]);

        // dd($validatedData);
        DataRekrutmen::create($validatedData);

        return redirect()->route('admin.rekrutmen')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataRekrutmen $rekrutmen, $id_rekrutmen)
    {
        return view('admin.rekrutmen.edit', [
            'title' => 'Edit Data Rekrutmen',
            'rekrutmen' => DataRekrutmen::with('ekskul')->where('id_rekrutmen', $id_rekrutmen)->first(),
            'ekskul' => EkskulModel::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_rekrutmen)
    {
        $rules = [
            'id_ekskul' => 'required|max:20',
            'nama_lowongan' => 'required|max:20',
            'tanggal_dimulai' => 'required',
            'tanggal_berakhir' => 'required',
            'deskripsi' => 'required',
        ];


        $validatedData = $request->validate($rules);

        DataRekrutmen::where('id_rekrutmen', $id_rekrutmen)->update($validatedData);

        return redirect()->route('admin.rekrutmen')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_rekrutmen)
    {
        DataRekrutmen::where('id_rekrutmen', $id_rekrutmen)->delete();
        return redirect()->route('admin.rekrutmen')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Ekstrakulikuler',
            'rekrutmen' => DataRekrutmen::with('ekskul')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.rekrutmen', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-rekrutmen.pdf');
    }
}
