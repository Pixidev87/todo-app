<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskServices;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private TaskServices $taskServices
    ){}

    public function index()
    {
        $this->taskServices->getAllTasksPaginated(10);
    }

    public function store(StoreTaskRequest $request)
    {
        $this->taskServices->create([
            $request->validated()
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $this->taskServices->update($task, [
            $request->validated()
        ]);
    }

    public function delete(Task $task)
    {
        $this->authorize('delete', $task);

        $this->taskServices->delete($task);

        return response()->noContent(204);
    }

    public function restore(int $id)
    {
        $this->taskServices->restore($id);
    }
}
