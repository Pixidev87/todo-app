<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class TaskController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    // Dependency Injection segítségével beillesztjük a TaskServices szolgáltatást
    public function __construct
    (
        private TaskServices $taskServices
    ){}

    // feladatok listázása a nézetben
    public function index(): View
    {
        // lekéri az összes feladatot a szolgáltatáson keresztül
        $tasks = $this->taskServices->getAllTasksPaginated(5);
        // lekéri a törölt feladatokat a szolgáltatáson keresztül
        $trashedTasks = $this->taskServices->getTrashedTasks();


        // visszaadja a feladatokat a nézetnek
        return view('tasks.index', [
            'tasks' => $tasks,
            'trashedTasks' => $trashedTasks,
        ]);
    }

    // új feladat létrehozása
    public function store(StoreTaskRequest $request): TaskResource
    {
        // létrehozza az új feladatot a szolgáltatáson keresztül a validált adatokkal
        $task = $this->taskServices->create(
            $request->toDto()
        );

        // visszaadja az új feladatot a TaskResource segítségével
        return new TaskResource($task);
    }

    // feladat állapotának váltása
    public function toggle(Task $task): RedirectResponse
    {
        // váltja a feladat állapotát a szolgáltatáson keresztül
        $this->taskServices->toggle($task);
        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'task toggled');
    }


    // feladat frissítése
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat frissítésére
        $this->authorize('update', $task);

        // frissíti a feladatot a szolgáltatáson keresztül a validált adatokkal
        $this->taskServices->update(
            $task, $request->toDto()
        );
        // átirányít a feladatok listájára
        return redirect()->route('tasks.index');
    }

    public function edit(Task $task): View
    {
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat frissítésére
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

        // feladat törlése
    public function destroy(Task $task): mixed
    {
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat törlésére
        $this->authorize('delete', $task);

        // törli a feladatot a szolgáltatáson keresztül
        $this->taskServices->delete($task);
        // visszaad egy üres választ a sikeres törlés jelzésére
        return response()->noContent();
    }

    // feladat visszaállítása
    public function restore(int $id): TaskResource
    {
        // lekéri a törölt feladatot azonosító alapján
        $task = Task::onlyTrashed()->findOrFail($id);
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat visszaállítására
        $this->authorize('restore', $task);
        // visszaállítja a feladatot a szolgáltatáson keresztül
        $task = $this->taskServices->restore($id);
        // visszaadja a visszaállított feladatot a TaskResource segítségével
        return new TaskResource($task);
    }
}
