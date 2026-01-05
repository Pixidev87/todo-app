<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Services\TaskServices;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class TaskController extends Controller
{
    // Dependency Injection segítségével beillesztjük a TaskServices szolgáltatást
    public function __construct
    (
        private TaskServices $taskServices
    ){}

    // feladatok listázása a nézetben
    public function index(): View
    {
        // lekéri az összes feladatot a szolgáltatáson keresztül
        $tasks = $this->taskServices->getAllTasks();

        // visszaadja a 'tasks.index' nézetet a feladatokkal együtt
        return view('tasks.index', compact('tasks'));
    }

    // új feladat létrehozása
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        // létrehozza az új feladatot a szolgáltatáson keresztül a validált adatokkal
        $this->taskServices->create(
            $request->validated()
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

    // feladat törlése
    public function destroy(Task $task): RedirectResponse
    {
        // törli a feladatot a szolgáltatáson keresztül
        $this->taskServices->destroy($task);
        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('tasks.index')->with('success', 'task deleted');
    }
}
