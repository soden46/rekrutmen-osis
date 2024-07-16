<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\PembinaModel;
use App\Models\SiswaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataPendaftaranController extends Controller
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
        $pembina = PembinaModel::where('id_user', $user->id)->first();
        $pembinaId = $pembina->id_pembina;

        if ($cari != NULL) {
            return view('pembina.pendaftaran.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                    ->whereHas('rekrutmen.ekskul', function ($query) use ($pembinaId) {
                        $query->where('id_pembina', $pembinaId);
                    })
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
            return view('pembina.pendaftaran.index', [
                'title' => 'Data Pendaftaran',
                'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                    ->whereHas('rekrutmen.ekskul', function ($query) use ($pembinaId) {
                        $query->where('id_pembina', $pembinaId);
                    })->paginate(10),
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
        return view('pembina.pendaftaran.create', [
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

        return redirect()->route('pembina.pendaftaran')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPendaftaran $pendaftaran, $id_pendaftaran)
    {
        $user = Auth::user();
        $pembina = PembinaModel::where('id_user', $user->id)->first();
        $pembinaId = $pembina->id_pembina;

        return view('pembina.pendaftaran.edit', [
            'title' => 'Edit Data pendaftaran',
            'pendaftaran' => DataPendaftaran::with('rekrutmen', 'siswa', 'rekrutmen.ekskul')
                ->whereHas('rekrutmen.ekskul', function ($query) use ($pembinaId) {
                    $query->where('id_pembina', $pembinaId);
                })->where('id_pendaftaran', $id_pendaftaran)->first(),
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
        // dd($request->all());
        $rules = [
            'tanggal' => 'required',
            'status' => 'required'
        ];


        $validatedData = $request->validate($rules);

        DataPendaftaran::where('id_pendaftaran', $id_pendaftaran)->update($validatedData);

        return redirect()->route('pembina.pendaftaran')->with('success', 'Data has ben updated');
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
        return redirect()->route('pembina.pendaftaran')->with('success', 'Data has ben deleted');
    }

    public function pdf()
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
