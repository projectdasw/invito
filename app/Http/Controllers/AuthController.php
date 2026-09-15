<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'login.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $login = $credentials['login'];

        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $user = User::where($field, $login)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors([
                    'login' => $field === 'email'
                        ? 'Email tidak terdaftar.'
                        : 'Username tidak terdaftar.',
                ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors([
                    'password' => 'Password salah.',
                ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}