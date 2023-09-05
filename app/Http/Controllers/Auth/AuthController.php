<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function auth(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|min:5|email|exists:users,email',
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt($validate)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }
        flash('Anda tidak terdaftar dalam sistem', 'error');

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();

        return redirect()->to('login');
    }
}
