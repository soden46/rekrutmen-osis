<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiswaModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataSiswaController extends Controller
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
            return view('admin.siswa.index', [
                'title' => 'Data Siswa',
                'siswa' => SiswaModel::with('users')
                    ->where(function ($query) use ($cari) {
                        $query->where('kelas', 'like', "%{$cari}%")
                            ->orWhereHas('users', function ($query) use ($cari) {
                                $query->where('nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'users' => User::get()
            ]);
        } else {
            return view('admin.siswa.index', [
                'title' => 'Data Siswa',
                'siswa' => SiswaModel::with('users')->paginate(10),
                'users' => User::get()
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
        return view('admin.siswa.create', [
            'title' => 'Tambah Data Siswa',
            'users' => User::get()
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
        // Validasi data
        $ValidatedData = $request->validate([
            'nama' => 'required|max:255',
            'nis' => 'required|unique:siswa',
            'password' => 'required|min:6|max:12',
        ]);

        // Menyimpan data ke database
        $userID = User::create([
            'nama' => $ValidatedData['nama'],
            'userName' => $ValidatedData['nis'],
            'password' => Hash::make($ValidatedData['password']),
            'role' => 'siswa',
        ]);

        SiswaModel::create([
            'id_user' => $userID->id,
            'nis' => $ValidatedData['nis'],
            'kelas' => $request->kelas,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(SiswaModel $siswa, $id_siswa)
    {
        return view('admin.siswa.edit', [
            'title' => 'Edit Data Siswa',
            'siswa' => SiswaModel::with('users')->where('id_siswa', $id_siswa)->first(),
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
    public function update(Request $request, $id_siswa)
    {
        $rules = [
            'nis' => 'max:255',
            'kelas' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'max:255',
            'jenis_kelamin' => 'max:255',
            'alamat' => 'max:255',
            'tinggai_badan' => 'max:255',
            'berat_badan' => 'max:255',
        ];


        $validatedData = $request->validate($rules);

        SiswaModel::where('id_siswa', $id_siswa)->update($validatedData);

        return redirect()->route('admin.siswa')->with('success', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_siswa)
    {
        SiswaModel::where('id_siswa', $id_siswa)->delete();
        return redirect()->route('admin.siswa')->with('success', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => SiswaModel::with('users')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.siswa', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('data-siswa.pdf');
    }
}
