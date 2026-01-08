<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::prefix('/tasks')->group(function (){
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

