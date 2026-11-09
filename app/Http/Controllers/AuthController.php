<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $usernameSanitized = str_replace(' ', '', $request->input('text_username'));
        $request->merge(['text_username' => $usernameSanitized]);
        
        $request->validate([
            'text_username' => 'required|min:3|alpha_num',
            'text_password' => 'required|min:6',
        ], [
            'text_username.required' => 'O campo usuário é obrigatório.',
            'text_username.min' => 'O campo usuário deve ter no mínimo 3 caracteres.',
            'text_username.alpha_num' => 'O nome de usuário não pode conter espaços ou caracteres especiais.',
            'text_password.required' => 'O campo password é obrigatório.',
            'text_password.min' => 'O campo password deve ter no mínimo 6 caracteres.',
        ]);

        $credentials = [
            'username' => $request->input('text_username'),
            'password' => $request->input('text_password'),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Auth::user()->update(['last_login' => now()]);

            return redirect()->intended('/');
        }

        return back()
            ->withInput()
            ->with('login_error', 'Username ou password incorretos!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}