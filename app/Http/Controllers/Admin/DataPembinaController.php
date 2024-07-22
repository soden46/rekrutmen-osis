<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembinaModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'nama' => 'required|max:255',
            'nip' => 'required|unique:pembina',
            'password' => 'required|min:6|max:12',
        ]);

        try {
            $userID = User::create([
                'nama' => $validatedData['nama'],
                'userName' => $validatedData['nip'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'pembina',
            ]);

            PembinaModel::create([
                'id_user' => $userID->id,
                'nip' => $validatedData['nip'],
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            return redirect()->route('admin.pembina')->with('success', 'Data has been created');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pembina')->with('error', 'Data could not be saved due to a foreign key constraint.');
        }
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
            'nip' => 'required|max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'date',
            'jenis_kelamin' => 'max:255',
        ];

        $validatedData = $request->validate($rules);

        try {
            PembinaModel::where('id_pembina', $id_pembina)->update($validatedData);
            return redirect()->route('admin.pembina')->with('success', 'Data has been updated');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pembina')->with('error', 'Data could not be updated due to a foreign key constraint.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pembina)
    {
        try {
            PembinaModel::where('id_pembina', $id_pembina)->delete();
            return redirect()->route('admin.pembina')->with('success', 'Data has been deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.pembina')->with('error', 'Data could not be deleted due to a foreign key constraint.');
        }
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
