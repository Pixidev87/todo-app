<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    //felhasználó regisztráció
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // jelszó hashelése a modelben történik a setPasswordAttribute metódussal
            'password' => $data['password']
        ]);

        // automatikus bejelentkeztetés regisztráció után
        Auth::login($user);

        return $user;
    }

    public function login(array $data): bool
    {
        return Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public function logout()
    {
        return Auth::logout();
    }
}
