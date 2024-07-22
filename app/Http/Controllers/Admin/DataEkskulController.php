<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EkskulModel;
use App\Models\PembinaModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;

class DataEkskulController extends Controller
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
            return view('admin.ekskul.index', [
                'title' => 'Data Ekstrakulikuler',
                'ekskul' => EkskulModel::with('pembina', 'pembina.users')
                    ->where(function ($query) use ($cari) {
                        $query->where('nama_ekskul', 'like', "%{$cari}%")
                            ->orWhereHas('pembina', function ($query) use ($cari) {
                                $query->where('nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10)
            ]);
        } else {
            return view('admin.ekskul.index', [
                'title' => 'Data Ekstrakulikuler',
                'ekskul' => EkskulModel::with('pembina', 'pembina.users')->paginate(10),
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
        return view('admin.ekskul.create', [
            'title' => 'Tambah Data Ekstrakulikuler',
            'pembina' => PembinaModel::get()
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
            'id_pembina' => 'required',
            'nama_ekskul' => 'required|max:255',
            'jml_anggota' => 'required|max:255',
        ]);

        try {
            EkskulModel::create($validatedData);
            return redirect()->route('admin.ekskul')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.ekskul')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(EkskulModel $ekskul, $id_ekskul)
    {
        return view('admin.ekskul.edit', [
            'title' => 'Edit Data Ekstrakulikuler',
            'ekskul' => EkskulModel::with('pembina')->where('id_ekskul', $id_ekskul)->first(),
            'pembina' => PembinaModel::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_ekskul)
    {
        $rules = [
            'id_pembina' => 'required',
            'nama_ekskul' => 'required|max:255',
            'jml_anggota' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        try {
            EkskulModel::where('id_ekskul', $id_ekskul)->update($validatedData);
            return redirect()->route('admin.ekskul')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.ekskul')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_ekskul)
    {
        try {
            EkskulModel::where('id_ekskul', $id_ekskul)->delete();
            return redirect()->route('admin.ekskul')->with('successDeletedMasyarakat', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.ekskul')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Ekstrakulikuler',
            'ekskul' => EkskulModel::with('pembina', 'pembina.users')->get(),
            'pembina' => PembinaModel::get()
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.ekskul', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-ekstrakulikuler.pdf');
    }
}
