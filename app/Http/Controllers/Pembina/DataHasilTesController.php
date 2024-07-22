<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\HasilPenerimaan;
use App\Models\PembinaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $pembina = PembinaModel::where('id_user', $user->id)->first();
        $pembinaId = $pembina->id_pembina;

        if ($cari != NULL) {
            return view('pembina.hasil.index', [
                'title' => 'Data Hasil Tes',
                'hasil' => HasilPenerimaan::with('pendaftaran', 'pendaftaran.rekrutmen.ekskul')
                    ->whereHas('pendaftaran.rekrutmen.ekskul', function ($query) use ($pembinaId) {
                        $query->where('id_pembina', $pembinaId);
                    })
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
            return view('pembina.hasil.index', [
                'title' => 'Data Hasil Tes',
                'hasil' => HasilPenerimaan::with('pendaftaran', 'pendaftaran.rekrutmen.ekskul')
                    ->whereHas('pendaftaran.rekrutmen.ekskul', function ($query) use ($pembinaId) {
                        $query->where('id_pembina', $pembinaId);
                    })->paginate(10),
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
        return view('pembina.hasil.create', [
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
        $validatedData = $request->validate([
            'id_pendaftaran' => 'required',
            'nama_tes' => 'required|max:255',
            'skor_final' => 'required',
            'status' => 'required',
        ]);

        try {
            HasilPenerimaan::create($validatedData);
            return redirect()->route('pembina.hasil')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pembina.hasil')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(HasilPenerimaan $hasil, $id_hasil)
    {
        $user = Auth::user();
        $pembina = PembinaModel::where('id_user', $user->id)->first();
        $pembinaId = $pembina->id_pembina;

        return view('pembina.hasil.edit', [
            'title' => 'Edit Data Hasil Tes',
            'hasil' => HasilPenerimaan::with('pendaftaran', 'pendaftaran.rekrutmen.ekskul')
                ->whereHas('pendaftaran.rekrutmen.ekskul', function ($query) use ($pembinaId) {
                    $query->where('id_pembina', $pembinaId);
                })
                ->where('id_hasil', $id_hasil)->first(),
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

        try {
            HasilPenerimaan::where('id_hasil', $id_hasil)->update($validatedData);
            return redirect()->route('pembina.hasil')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pembina.hasil')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_hasil)
    {
        try {
            HasilPenerimaan::where('id_hasil', $id_hasil)->delete();
            return redirect()->route('pembina.hasil')->with('success', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('pembina.hasil')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Hasil Tes',
            'hasil' => HasilPenerimaan::with('pendaftaran')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.hasil', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-hasil-tes.pdf');
    }
}
