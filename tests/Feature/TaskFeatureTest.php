<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_user_sees_only_own_tasks()
    {

        // Létrehozunk két felhasználót és néhány feladatot mindkettőhöz
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Feladatok létrehozása a felhasználókhoz
        Task::factory()->count(2)->create(['user_id' => $user->id]);
        Task::factory()->count(1)->create(['user_id' => $otherUser->id]);

        // Bejelentkezés az első felhasználóval és a feladatok oldalának lekérése
        $response = $this->actingAs($user)->get(route('tasks.index'));

        // Ellenőrizzük, hogy csak az első felhasználó feladatai jelennek meg
        $response->assertStatus(200);
        $response->assertViewHas('tasks', function($tasks){
            return $tasks->count() === 2;
        });
    }


    public function test_user_cannot_edit_other_users_task()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        // Próbáljuk meg szerkeszteni a másik felhasználó feladatát
        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        // Ellenőrizzük, hogy hozzáférés megtagadva választ kapunk
        $response->assertStatus(403);
    }


    public function test_task_creation_requires_title()
    {
        $user = User::factory()->create();

        // Próbáljuk meg létrehozni a feladatot cím nélkül
        $response = $this->actingAs($user)->post(route('tasks.store'), ['title' => '']);

        // Ellenőrizzük, hogy a validáció hibát adott-e vissza
        $response->assertSessionHasErrors('title');
    }


    public function test_user_can_update_own_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'updated title',
            'description' => 'updated description',
            
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [

            'id' => $task->id,
            'title' => 'updated title',
        ]);
    }


    public function test_tasks_index_shows_pagination()
    {
        $user = User::factory()->create();
        //15 feladat oldalanként
        Task::factory()->count(15)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertStatus(200);

        // Ellenőrizzük, hogy 5 feladat van az első oldalon
        $tasks = $response->viewData('tasks');
        $this->assertCount(5, $tasks);

        // Ellenőrizzük, hogy a paginate linkek megjelennek az oldalon
        $response->assertSee('pagination');
    }



}
