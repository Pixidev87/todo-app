<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::prefix('/tasks')->middleware('auth')->group(function (){
    // feladatok listázása
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    // új feladat létrehozása
    Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
    // feladat állapotának váltása
    Route::put('/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    // feladat törlése
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    // feladat frissítése, szerkesztése
    Route::get('/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
    // feladat frissítése
    Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
});

//Autentikáció
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


