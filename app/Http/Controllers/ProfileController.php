<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Siswa\SiswaController;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BioModel;
use App\Models\PembinaModel;
use App\Models\SiswaModel;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::get();
        $admin = AdminModel::get();
        $pembina = PembinaModel::get();
        $siswa = SiswaModel::get();
        return view('profile', compact('user', 'admin', 'pembina', 'siswa'));
    }

    public function update(Request $request, User $user)
    {
        if ($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = $request->old_password;
        }
        return back()->with('success', 'Profil Anda Sukses Diperbaharui');
    }
    public function save(Request $request, User $user)
    {

        if (Auth::user()->role == "siswa") {
            $validatedData = $request->validate([
                'id_user' => 'nullable',
                'nis' => 'nullable',
                'kelas' => 'nullable',
                'tempat_lahir' => 'nullable',
                'tanggal_lahir' => 'nullable',
                'jenis_kelamin' => 'nullable',
                'alamat' => 'nullable',
            ]);
            $id_user = $request->id_user;

            User::where('id', $id_user)->update([
                "nama" => $request->nama,
                "userName" => $validatedData['nis'],
                "password" => Hash::make($request->password)
            ]);
            SiswaModel::create($validatedData);
        } elseif (Auth::user()->role == "admin") {
            $validatedData = $request->validate([
                'id_user' => 'nullable',
                'nip' => 'nullable',
                'kelas' => 'nullable',
                'tempat_lahir' => 'nullable',
                'tanggal_lahir' => 'nullable',
                'jenis_kelamin' => 'nullable',
            ]);
            $id_user = $request->id_user;

            User::where('id', $id_user)->update([
                "nama" => $request->nama,
                "userName" => $validatedData['nip'],
                "password" => Hash::make($request->password)
            ]);
            AdminModel::create($validatedData);
        } else {
            $validatedData = $request->validate([
                'id_user' => 'nullable',
                'nip' => 'nullable',
                'kelas' => 'nullable',
                'tempat_lahir' => 'nullable',
                'tanggal_lahir' => 'nullable',
                'jenis_kelamin' => 'nullable',
            ]);
            $id_user = $request->id_user;

            User::where('id', $id_user)->update([
                "nama" => $request->nama,
                "userName" => $validatedData['nip'],
                "password" => Hash::make($request->password)
            ]);
            PembinaModel::create($validatedData);
        }
        return back()->with('success', 'Biodata Sukses Diperbaharui');
    }
}
