<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function index()
    {
        return view('_auth.login');
    }

    // TODO: Tambah role
    public function auth(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            // Alert::success('Sukse!', 'Post Created Successfully');
            return redirect()
                    ->intended('/dashboard');
        } else {
            Alert::error('Gagal!', 'Email or Password doesn`t match');
            return redirect()
                ->back()
                ->with('error',  'Email/Password Salah!');
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
