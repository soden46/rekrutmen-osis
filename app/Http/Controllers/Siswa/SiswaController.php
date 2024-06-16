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
		$siswa = SiswaModel::where('id_user', Auth::user()->id)->first();
		$rekrutmen = DataRekrutmen::where('tanggal_berakhir', now())->count();
		$pendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)->count();
		return view('siswa.index', compact('siswa', 'rekrutmen', 'pendaftaran'));
	}
	public function lamar(Request $request)
	{
		$siswa = SiswaModel::where('id_user', Auth::user()->id)->first();
		$rekrutmen = DataRekrutmen::where('tanggal_berakhir', now())->count();
		$pendaftaran = DataPendaftaran::where('id_siswa', $siswa->id_siswa)->count();
		return view('siswa.lamaran', compact('rekrutmen',));
	}

	public function store(Request $request)
	{
		$ValidatedData = $request->validate([
			'id_siswa' => ['required', 'max:255'],
			'id_berita' => ['required', 'max:255'],
			'lowongan' => ['required', 'max:255'],
			'alamat_caffe' => ['required', 'min:6'],
		]);

		Lamaran::create($ValidatedData);
		return redirect()->back()
			->with('success', 'Lamaran Anda Berhasil Disimpan dan Menunggu Ditindaklanjuti');
	}

	public function status()
	{
		//get posts
		$lamaran = Lamaran::where('siswa.id_user', '=', Auth::user()->id)->join('siswa', 'lamaran.id_siswa', '=', 'siswa.id_siswa')
			->get(['lamaran.*', 'siswa.*']);
		//render view with posts
		return view('siswa.status', compact('lamaran'));
	}
	public function lowongan()
	{
		$news = News::where('kategori', '=', "Lowongan Kerja")->where('status_lowongan', '=', 'Lowongan Tersedia')
			->get();
		//render view with posts
		return view('siswa.lowongan', compact('news'));
	}
}
