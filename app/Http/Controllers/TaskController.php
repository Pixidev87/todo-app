<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskServices;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


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
    public function store(StoreTaskRequest $request)
    {
        // létrehozza az új feladatot a szolgáltatáson keresztül a validált adatokkal
        $this->taskServices->create(
            $request->validated()
        );

        // átirányít a feladatok listájára egy sikeres üzenettel
        return redirect()->route('task.index')->with('success', 'task created');
    }
}
