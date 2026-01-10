<?php

namespace App\Providers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    // TaskPolicy regisztrálása a Gate számára
    public function boot(): void
    {
        // A Task modellhez a TaskPolicy társítása
        Gate::policy(Task::class, TaskPolicy::class);
    }
}
