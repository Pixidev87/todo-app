<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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


        // visszaadja a 'tasks.index' nézetet a feladatokkal együtt
        return view('tasks.index', compact('tasks', 'trashedTasks'));
    }

    // új feladat létrehozása
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        // létrehozza az új feladatot a szolgáltatáson keresztül a validált adatokkal
        $this->taskServices->create(
            $request->toDto()
        );

        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'task created');
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
        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'Updated is successfully');
    }

    public function edit(Task $task): View
    {
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat frissítésére
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

        // feladat törlése
    public function destroy(Task $task): RedirectResponse
    {
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat törlésére
        $this->authorize('delete', $task);

        // törli a feladatot a szolgáltatáson keresztül
        $this->taskServices->delete($task);
        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'task deleted');
    }

    // feladat visszaállítása
    public function restore(int $id): RedirectResponse
    {
        // lekéri a törölt feladatot azonosító alapján
        $task = Task::onlyTrashed()->findOrFail($id);
        // ellenőrzi, hogy a felhasználó jogosult-e a feladat visszaállítására
        $this->authorize('restore', $task);
        // visszaállítja a feladatot a szolgáltatáson keresztül
        $this->taskServices->restore($id);
        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'Task restore');
    }
}
