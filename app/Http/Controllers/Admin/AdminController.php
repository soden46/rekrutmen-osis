<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\News;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Caffe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function index(Request $request)
    {
        $cari = $request->cari;

        if ($cari != NULL) {
            return view('admin.admin.index', [
                'title' => 'Data Admin',
                'admin' => AdminModel::with('users')
                    ->where(function ($query) use ($cari) {
                        $query->where('nip', 'like', "%{$cari}%")
                            ->orWhereHas('users', function ($query) use ($cari) {
                                $query->where('nama', 'like', "%{$cari}%");
                            });
                    })
                    ->paginate(10),
                'user' => User::get()
            ]);
        } else {
            return view('admin.admin.index', [
                'title' => 'Data Admin',
                'admin' => AdminModel::with('users')->paginate(10),
                'user' => User::get()
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
        return view('admin.admin.create', [
            'title' => 'Tambah Data Admin',
            'user' => User::get()
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
            'nis' => 'max:255',
            'kelas' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'max:255',
            'jenis_kelamin' => 'max:255',
            'alamat' => 'max:255',
            'tinggai_badan' => 'max:255',
            'berat_badan' => 'max:255',
            'kelas' => 'max:255',
            'kelas' => 'max:255',
            'kelas' => 'max:255',
        ]);

        // dd($validatedData);
        AdminModel::create($validatedData);

        return redirect()->route('admin.didwa')->with('successCreatedPenduduk', 'Data has ben created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminModel $admin, $id_admin)
    {
        return view('admin.admin.edit', [
            'title' => 'Edit Data Admin',
            'admin' => AdminModel::with('users')->where('id_admin', $id_admin)->first(),
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
    public function update(Request $request, $id_admin)
    {
        $rules = [
            'nip' => 'max:255',
            'kelas' => 'max:255',
            'tempat_lahir' => 'max:255',
            'tanggal_lahir' => 'max:255',
            'alamat' => 'max:255',
            'jenis_kelamin' => 'max:255',
        ];


        $validatedData = $request->validate($rules);

        AdminModel::where('id_admin', $id_admin)->update($validatedData);

        return redirect()->route('admin.admin')->with('successUpdatedMasyarakat', 'Data has ben updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penduduk  $masyarakat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_admin)
    {
        AdminModel::where('id_admin', $id_admin)->delete();
        return redirect()->route('admin.admin')->with('successDeletedMasyarakat', 'Data has ben deleted');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Data Admin',
            'admin' => AdminModel::with('users')->get(),
        ];

        $customPaper = [0, 0, 567.00, 500.80];
        $pdf = Pdf::loadView('admin.laporan.admin', $data)->setPaper('customPaper', 'potrait');
        return $pdf->stream('surat-keterangan-biasa.pdf');
    }
}
