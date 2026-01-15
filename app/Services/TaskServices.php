<?php

namespace App\Services;

use App\DTOs\Task\TaskData;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function create(TaskData $data)
    {
        // létrehoz egy új feladatot a jelenlegi felhasználóhoz kapcsolva
        return Auth::user()->tasks()->create([
            'title' => $data->title,
            'description' => $data->description ?? null,
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

    public function update(Task $task, TaskData $data): Task
    {
        $task->update([
            'title' => $data->title,
            'description' => $data->description ?? null
        ]);

        return $task;
    }

    // lapozott feladatok lekérdezése
    public function getAllTasksPaginated(int $perPage = 10): LengthAwarePaginator
    {
        // visszaadja a jelenlegi felhasználó feladatait lapozva
        return Auth::user()->tasks()->latest()->paginate($perPage);
    }

    // feladat végleges törlése
    public function delete(Task $task): void
    {
        // véglegesen törli a megadott feladatot az adatbázisból
        $task->delete();
    }

    // feladat visszaállítása a lomtárból
    public function restore(int $taskId): bool
    {
        // visszaállítja a megadott azonosítójú feladatot, ha az a jelenlegi felhasználóhoz tartozik
        return Task::onlyTrashed() // lekérdezi a lomtárban lévő feladatokat
            ->where('id', $taskId) // csak a lomtárban lévő feladatok közül keres
            ->where('user_id', Auth::id()) // csak a jelenlegi felhasználó feladatai között keres
            ->firstOrFail() // ha nincs találat, hibát dob
            ->restore(); // visszaállítja a feladatot
    }

    // lomtárban lévő feladatok lekérdezése
    public function getTrashedTasks(): mixed
    {
        // visszaadja a jelenlegi felhasználó lomtárban lévő feladatait
        return Auth::user() // jelenlegi felhasználó
            ->tasks() // felhasználó feladatai
            ->onlyTrashed() // csak a lomtárban lévő feladatok
            ->latest() // legfrissebbek előre
            ->get(); // lekéri az összes feladatot
    }
}
