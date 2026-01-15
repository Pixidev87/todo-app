<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskServices;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private TaskServices $taskServices
    ){}

    public function index(): LengthAwarePaginator
    {
        return $this->taskServices->getAllTasksPaginated(10);
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->taskServices->create($request->toDto());
    }

    public function update(UpdateTaskRequest $request, Task $task): Task
    {
        $this->authorize('update', $task);

        return $this->taskServices->update($task, $request->toDto());
    }

    public function delete(Task $task): Response
    {
        $this->authorize('delete', $task);

        $this->taskServices->delete($task);

        return response()->noContent(204);
    }

    public function restore(int $id): bool
    {
        return $this->taskServices->restore($id);
    }
}
