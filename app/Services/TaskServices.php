<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TaskServices
{
    // lekérdezi az összes feladatot
    public function getAllTasks(): Collection
    {
        // Auth::user() - a jelenleg bejelentkezett felhasználót adja vissza
        // tasks() - a felhasználóhoz tartozó feladatok lekérdezése
        // latest() - a legfrissebb feladatokat hozza előre
        // get() - lekéri az összes feladatot
        return Auth::user()->tasks()->latest()->get();
    }

    // új feladat létrehozása
    public function create(array $data)
    {
        // létrehoz egy új feladatot a jelenlegi felhasználóhoz kapcsolva
        return Auth::user()->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);
    }

    // feladat állapotának váltása (kész/nem kész)
    public function toggle(Task $task): Task
    {
        // frissíti a feladat "is_completed" mezőjét az ellenkező értékre
        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);
        // visszatér a frissített feladattal
        return $task;
    }

    // feladat törlése
    public function destroy(Task $task): void
    {
        // törli a megadott feladatot az adatbázisból
        $task->delete();
    }

    public function update(Task $task, array $data): Task
    {
        $task->update([
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        return $task;
    }
}
