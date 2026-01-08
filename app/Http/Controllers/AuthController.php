<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->authService->register($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Register completed');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if($this->authService->login($request->validated())){
            return redirect()->route('tasks.index')->with('Login is ok!');
        }

        return back()->withErrors(
            ['Email' => 'Email is invalid',
                       'Password' => 'Password is incorrect'
        ]);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('auth.login')->with('succes', 'Logout is succesfuly');
    }
}
