<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataJadwaltes;
use App\Models\DataRekrutmen;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataJadwalTesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari;
        $user = Auth::user();
        $siswa = SiswaModel::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Siswa tidak ditemukan');
        }

        $siswaId = $siswa->id_siswa;

        // Ambil ID rekrutmen dari tabel pendaftaran berdasarkan id_siswa
        $rekrutmenIds = Pendaftaran::where('id_siswa', $siswaId)->pluck('id_rekrutmen');

        $query = DataJadwaltes::with('rekrutmen', 'rekrutmen.ekskul')
            ->whereIn('id_rekrutmen', $rekrutmenIds);

        if ($cari) {
            $query->where(function ($query) use ($cari) {
                $query->where('nama_jadwal_tes', 'like', "%{$cari}%")
                    ->orWhere('tanggal', 'like', "%{$cari}%")
                    ->orWhereHas('rekrutmen', function ($query) use ($cari) {
                        $query->where('nama_lowongan', 'like', "%{$cari}%");
                    });
            });
        }

        $tes = $query->paginate(10);

        return view('siswa.jadwal.index', [
            'title' => 'Data Jadwal Tes',
            'tes' => $tes,
            'rekrutmen' => DataRekrutmen::get(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('siswa.jadwal.create', [
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
        // dd($request);

        $validatedData = $request->validate([
            'id_rekrutmen' => 'required',
            'nama_jadwal_tes' => 'required|max:255',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        // dd($validatedData);
        DataJadwaltes::create($validatedData);

        return redirect()->route('siswa.jadwal')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataJadwaltes $jadwal, $id_jadwal)
    {
        $user = Auth::user();
        $siswa = siswaModel::where('id_user', $user->id)->first();

        $siswaId = $siswa->id_siswa;

        return view('siswa.jadwal.edit', [
            'title' => 'Edit Data Jadwal Tes',
            'tes' => DataJadwaltes::with('rekrutmen', 'rekrutmen.ekskul')
                ->whereHas('rekrutmen.ekskul', function ($query) use ($siswaId) {
                    $query->where('id_siswa', $siswaId);
                })
                ->where('id_jadwal', $id_jadwal)
                ->first(),
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
            'tanggal' => 'required',
            'jam' => 'required',
        ];


        $validatedData = $request->validate($rules);

        DataJadwaltes::where('id_jadwal', $id_jadwal)->update($validatedData);

        return redirect()->route('siswa.jadwal')->with('success', 'Data has ben updated');
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
        return redirect()->route('siswa.jadwal')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Ekstrakulikuler',
            'tes' => DataJadwaltes::with('pendaftaran')->get(),

        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('siswa.laporan.jadwal', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-jadwal-tes.pdf');
    }
}
