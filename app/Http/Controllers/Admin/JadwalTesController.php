<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJadwaltes;
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
                'tes' => DataJadwaltes::with('siswa')
                    ->where(function ($query) use ($cari) {
                        $query->where('nama_jadwal_tes', 'like', "%{$cari}%")
                            ->orWhere('tanggal', 'like', "%{$cari}%")
                            ->orWhereHas('siswa', function ($query) use ($cari) {
                                $query->where('users->nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'siswa' => SiswaModel::get(),
            ]);
        } else {
            return view('admin.jadwal.index', [
                'title' => 'Data Jadwal Tes',
                'tes' => DataJadwaltes::with('siswa')->paginate(10),
                'siswa' => SiswaModel::get(),

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
            'nama_jadwal_tes' => 'required|max:255',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        // dd($validatedData);
        DataJadwaltes::create($validatedData);

        return redirect()->route('admin.jadwal')->with('success', 'Data has ben created');
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
    public function update(Request $request, $id_jadwal)
    {
        $rules = [
            'id_siswa' => 'required',
            'nama_jadwal_tes' => 'required|max:255',
            'tanggal' => 'required',
            'jam' => 'required',
        ];


        $validatedData = $request->validate($rules);

        DataJadwaltes::where('id_jadwal', $id_jadwal)->update($validatedData);

        return redirect()->route('admin.jadwal')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jadwal)
    {
        DataJadwaltes::where('id_jadwal', $id_jadwal)->delete();
        return redirect()->route('admin.jadwal')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Ekstrakulikuler',
            'tes' => DataJadwaltes::with('siswa')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.jadwal', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('surat-keterangan-biasa.pdf');
    }
}
