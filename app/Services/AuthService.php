<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(
     string $email,
     string $password,
     bool $remember = false
):   bool {

    return Auth::attempt([
        'email' => $email,
        'password' => $password,
        'is_active' => true,
    ], $remember);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function user()
    {
        return Auth::user();
    }

    public function check(): bool
    {
        return Auth::check();
    }
}