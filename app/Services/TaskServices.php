<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskServices
{
    // lekérdezi az összes feladatot
    public function getAllTasks(): Collection
    {
        // latest() - a legfrissebb feladatokat hozza előre
        // get() - lekéri az összes feladatot
        return Task::latest()->get();
    }

    // új feladat létrehozása
    public function create(array $data)
    {
        // létrehozza az új feladatot az adatbázisban a megadott adatokkal
        return Task::create([
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
}
