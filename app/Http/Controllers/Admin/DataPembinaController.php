<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembinaModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DataPembinaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('admin.pembina.index', [
                'title' => 'Data Pembina',
                'pembina' => PembinaModel::with('users')
                    ->where(function ($query) use ($cari) {
                        $query->where('nip', 'like', "%{$cari}%")
                            ->orWhereHas('users', function ($query) use ($cari) {
                                $query->where('nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'user' => User::where('role', 'pembina')->get()
            ]);
        } else {
            return view('admin.pembina.index', [
                'title' => 'Data Pembina',
                'pembina' => PembinaModel::with('users')->paginate(10),
                'user' => User::where('role', 'pembina')->get()
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
        return view('admin.pembina.create', [
            'title' => 'Tambah Data Pembina',
            'pembina' => PembinaModel::with('users')->first(),
            'user' => User::where('role', 'pembina')->get(),
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
            'id_user' => 'max:255',
            'nip' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'max:255',
            'jenis_kelamin' => 'max:255',
        ]);

        // dd($validatedData);
        PembinaModel::create($validatedData);

        return redirect()->route('admin.siswa')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(PembinaModel $pembina, $id_pembina)
    {
        return view('admin.pembina.edit', [
            'title' => 'Edit Data Pembina',
            'pembina' => PembinaModel::with('users')->where('id_pembina', $id_pembina)->first(),
            'user' => User::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pembina)
    {
        $rules = [
            'id_user' => 'max:255',
            'nip' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'max:255',
            'jenis_kelamin' => 'max:255',
        ];


        $validatedData = $request->validate($rules);

        PembinaModel::where('id_pembina', $id_pembina)->update($validatedData);

        return redirect()->route('admin.pembina')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pembina)
    {
        PembinaModel::where('id_pembina', $id_pembina)->delete();
        return redirect()->route('admin.pembina')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Pembina',
            'pembina' => PembinaModel::with('users')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.pembina', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-pembina.pdf');
    }
}
