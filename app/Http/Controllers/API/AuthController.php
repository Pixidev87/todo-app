<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    // felhasználó regisztráció
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        // létrehozza az új felhasználót a regisztrációs adatokkal
        $user = User::create([
            'name' => $registerRequest->name,
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password)
        ]);
        // létrehoz egy új API tokent a felhasználó számára
        $token = $user->createToken('api-token')->plainTextToken;
        // visszaadja a felhasználó adatait és a tokent JSON formátumban
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // felhasználó bejelentkezés
    public function login(LoginRequest $request): JsonResponse
    {
        // megkeresi a felhasználót az email cím alapján
        $user = User::where('email', $request->email)->first();
        // ellenőrzi a jelszót vagy a felhasználót és ha nem megfelelő valamelyik, hibás üzenetet ad vissza
        if (! $user || ! Hash::check($request->password , $user->password) ){
            return response()->json([
                'message' => 'incorrect login details'
            ], 401);
        }
        // létrehoz egy új API tokent a felhasználó számára
        $token = $user->createToken('api-token')->plainTextToken;
        // visszaadja a felhasználó adatait és a tokent JSON formátumban
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // felhasználó kijelentkezés
    public function logout(): JsonResponse
    {
        // törli a felhasználó összes API tokenjét
        auth()->user()->tokens()->delete();
        // visszaad egy sikeres kijelentkezési üzenetet JSON formátumban
        return response()->json([
            'message' => 'logout successfully'
        ]);
    }
}
