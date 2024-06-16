<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataRekrutmen;
use App\Models\Siswa;
use App\Models\Lamaran;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
	public function index()
	{
		$siswa = SiswaModel::with('users')->where('id_user', Auth::user()->id)->first();
		$rekrutmen = DataRekrutmen::where('tanggal_berakhir', now())->count();
		$pendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)->count();
		return view('siswa.index', compact('siswa', 'rekrutmen', 'pendaftaran'));
	}

	public function profile()
	{
		$siswa = SiswaModel::where('id_user', Auth::user()->id)->first();
		return view('siswa.profile', compact('siswa'));
	}


	public function storeProfile()
	{
		$siswa = SiswaModel::where('id_user', Auth::user()->id)->first();
		$rekrutmen = DataRekrutmen::where('tanggal_berakhir', now())->count();
		$pendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)->count();
		return view('siswa.profile', compact('siswa', 'rekrutmen', 'pendaftaran'));
	}
}
