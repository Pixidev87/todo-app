<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    // meghatározza, hogy a felhasználó frissítheti-e a feladatot
    public function update(User $user, Task $task): bool
    {
        // csak a feladat tulajdonosa frissítheti
        return $task->user_id === $user->id;
    }

    // meghatározza, hogy a felhasználó törölheti-e a feladatot
    public function delete(User $user, Task $task): bool
    {
        // csak a feladat tulajdonosa törölheti
        return $task->user_id === $user->id;
    }
}
