<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use Carbon\Carbon;

class SoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_is_soft_deleted()
    {
        // Létrehozunk egy felhasználót és egy feladatot
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        // Töröljük a feladatot
        $this->actingAs($user)->delete(route('tasks.destroy', $task));
        // Ellenőrizzük, hogy a feladat soft delete lett-e
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }


    // Teszteljük, hogy a felhasználó vissza tudja állítani a saját feladatát
    public function test_user_can_restore_own_task()
    {
        // Létrehozunk egy felhasználót és egy archivált feladatot
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'deleted_at' => Carbon::now(),
        ]);
        // Visszaállítjuk a feladatot
        $this->actingAs($user)->put(route('tasks.restore', $task->id));
        // Ellenőrizzük, hogy a feladat vissza lett állítva
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'deleted_at' => null,
        ]);
    }

    // Teszteljük, hogy a felhasználó nem tudja visszaállítani más felhasználó feladatát
    public function test_user_cannot_restore_other_users_task()
    {
        // Létrehozunk egy archivált feladatot egy felhasználóhoz
        $task = Task::factory()->create([
            'deleted_at' => Carbon::now(),
        ]);
        // Létrehozunk egy másik felhasználót
        $user = User::factory()->create();
        // Megpróbáljuk visszaállítani a feladatot a másik felhasználóval
        $this->actingAs($user)->put(route('tasks.restore', $task->id))->assertStatus(404);


    }
}
