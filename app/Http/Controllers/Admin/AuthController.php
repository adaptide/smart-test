<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\Role;
use App\Http\Requests\LoginRequest;

final class AuthController
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

         if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            if ($user->hasRole(Role::manager()->value)) {
                return redirect()->intended('/admin/tickets');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}