<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    public function index()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('login.index', [
                'judul' => 'Login',
                'active' => 'login'
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('userName', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('User logged in: ', ['userName' => $user->userName, 'role' => $user->role]);

            if ($user->role == 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->role == 'pembina') {
                return redirect()->route('pembina.index');
            } elseif ($user->role == 'siswa') {
                return redirect()->route('siswa.index');
            }
        } else {
            Log::warning('Failed login attempt: ', ['email' => $request->input('email')]);
            return redirect()->route('login')
                ->with('error', 'Email atau Password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
