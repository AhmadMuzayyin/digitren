<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => auth()->user()->name.' Login pada '.date('d F Y H:i s'),
            ]);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }
        flash('Anda tidak terdaftar dalam sistem', 'error');

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name.' Logout pada '.date('d F Y H:i s'),
        ]);
        Auth::logout();
        $request->session()->regenerateToken();

        return redirect()->to('login');
    }
}
