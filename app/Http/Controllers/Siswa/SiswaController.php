<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\Siswa;
use App\Models\Lamaran;
use App\Models\SiswaModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
	public function index()
	{
		$siswa = SiswaModel::with('users')->where('id_user', Auth::user()->id)->first();
		$rekrutmen = DataRekrutmen::where('tanggal_berakhir', now())->count();
		$pendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)->count();
		return view('profile', compact('siswa', 'rekrutmen', 'pendaftaran'));
	}

	public function profile()
	{
		$siswa = SiswaModel::where('id_user', Auth::user()->id)->first();
		return view('siswa.profile', compact('siswa'));
	}


	public function storeProfile(Request $request, $id)
	{
		$request->validate([
			'nama' => 'required|string|max:255',
			'nis' => 'required|string|max:255',
			'kelas' => 'required|string|max:255',
			'tempat_lahir' => 'required|string|max:255',
			'tanggal_lahir' => 'required|date',
			'jenis_kelamin' => 'required|string',
			'tinggi_badan' => 'required|numeric',
			'berat_badan' => 'required|numeric',
		]);

		// Update nama user
		$user = User::find($id);
		$user->nama = $request->input('nama');
		$user->save();

		// Update Siswa data
		$siswa = SiswaModel::where('id_user', $id)->first();
		$siswa->nis = $request->input('nis');
		$siswa->kelas = $request->input('kelas');
		$siswa->tempat_lahir = $request->input('tempat_lahir');
		$siswa->tanggal_lahir = $request->input('tanggal_lahir');
		$siswa->jenis_kelamin = $request->input('jenis_kelamin');
		$siswa->tinggi_badan = $request->input('tinggi_badan');
		$siswa->berat_badan = $request->input('berat_badan');
		$siswa->save();
		return redirect()->back()->with('success, Data Profile sukses diperbaharui');
	}
}
