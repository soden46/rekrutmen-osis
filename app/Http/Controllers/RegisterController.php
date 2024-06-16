<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelamar;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerifikasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $ValidatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:12',
        ]);

        // Menyimpan data ke database
        User::create([
            'email' => $ValidatedData['email'],
            'nama' => $ValidatedData['nama'],
            'userName' => $ValidatedData['username'],
            'password' => Hash::make($ValidatedData['password']),
            'role' => 'siswa',
        ]);

        // Redirect dengan pesan sukses
        return redirect('/login')
            ->with('success', 'Akun berhasil dibuat');
    }

    public function verify($verify_key)
    {
        $keyCheck = User::select('verify_key')
            ->where('verify_key', $verify_key)
            ->exists();

        if ($keyCheck) {
            $user = User::where('verify_key', $verify_key)
                ->update([
                    'active' => 1
                ]);

            return "Verifikasi Berhasil. Akun Anda sudah aktif.";
        } else {
            return "Key tidak valid!";
        }
    }
}
