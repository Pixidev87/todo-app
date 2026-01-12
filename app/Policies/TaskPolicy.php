<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    // Meghatározza, hogy a felhasználó megtekintheti-e a feladatot
    public function view(User $user, Task $task): bool
    {
        // Csak a saját feladatokat tekintheti meg
        return $this->ownsTask($user, $task);
    }

    // Meghatározza, hogy a felhasználó frissítheti-e a feladatot
    public function update(User $user, Task $task): bool
    {
        // Csak a saját feladatokat frissítheti
        return $this->ownsTask($user, $task);
    }

    // Meghatározza, hogy a felhasználó törölheti-e a feladatot
    public function delete(User $user, Task $task): bool
    {
        // Csak a saját feladatokat törölheti
        return $this->ownsTask($user, $task);
    }

    // Meghatározza, hogy a felhasználó visszaállíthatja-e a feladatot
    public function restore(User $user, Task $task): bool
    {
        // Csak a saját feladatokat állíthatja vissza
        return $this->ownsTask($user, $task);
    }

    // Segédfüggvény annak ellenőrzésére, hogy a felhasználó a feladat tulajdonosa-e
    private function ownsTask(User $user, Task $task): bool
    {
        // Ellenőrizzük, hogy a felhasználó azonosítója megegyezik-e a feladat felhasználóazonosítójával
        return $user->id === $task->user_id;
    }
}
