<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\Caffe;
use App\Models\LowonganPekerjaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            abort(403);
        }
        if (auth()->user()->role == 'admin') {
            return view('admin.index');
        }
        if (auth()->user()->role == 'pembina') {
            return view('pembina.index');
        }
        if (auth()->user()->role == 'siswa') {
            return view('siswa.index');
        }
    }
}
