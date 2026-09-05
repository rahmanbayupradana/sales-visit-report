<?php

namespace App\Http\Controllers;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    //Ini contoh Dependency Injection.
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

        if ($this->authService->login(
            $credentials['email'],
            $credentials['password'],
            $remember
        )) {

            $request->session()->regenerate();

            return redirect()
                ->intended('/dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
