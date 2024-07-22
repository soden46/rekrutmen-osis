<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJadwaltes;
use App\Models\DataRekrutmen;
use App\Models\SiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class JadwalTesController extends Controller
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
            return view('admin.jadwal.index', [
                'title' => 'Data Jadwal Tes',
                'tes' => DataJadwaltes::with('rekrutmen')
                    ->where(function ($query) use ($cari) {
                        $query->where('nama_jadwal_tes', 'like', "%{$cari}%")
                            ->orWhere('tanggal', 'like', "%{$cari}%")
                            ->orWhereHas('rekrutmen', function ($query) use ($cari) {
                                $query->where('users->nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'rekrutmen' => DataRekrutmen::get(),
            ]);
        } else {
            return view('admin.jadwal.index', [
                'title' => 'Data Jadwal Tes',
                'tes' => DataJadwaltes::with('rekrutmen')->paginate(10),
                'rekrutmen' => DataRekrutmen::get(),

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
        return view('admin.jadwal.create', [
            'title' => 'Tambah Data Jadwal Tes',
            'rekrutmen' => DataRekrutmen::get()

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
        $validatedData = $request->validate([
            'id_rekrutmen' => 'required',
            'nama_jadwal_tes' => 'required|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        try {
            DataJadwaltes::create($validatedData);
            return redirect()->route('admin.jadwal')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.jadwal')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataJadwaltes $jadwal, $id_jadwal)
    {
        return view('admin.jadwal.edit', [
            'title' => 'Edit Data Jadwal Tes',
            'tes' => DataJadwaltes::with('siswa')->where('id_jadwal', $id_jadwal)->first(),
            'rekrutmen' => DataRekrutmen::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_jadwal)
    {
        $rules = [
            'id_rekrutmen' => 'required',
            'nama_jadwal_tes' => 'required|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ];

        $validatedData = $request->validate($rules);

        try {
            DataJadwaltes::where('id_jadwal', $id_jadwal)->update($validatedData);
            return redirect()->route('admin.jadwal')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.jadwal')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jadwal)
    {
        try {
            DataJadwaltes::where('id_jadwal', $id_jadwal)->delete();
            return redirect()->route('admin.jadwal')->with('success', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.jadwal')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Ekstrakulikuler',
            'tes' => DataJadwaltes::with('siswa')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.jadwal', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-jadwal-tes.pdf');
    }
}
