<?php

namespace App\Providers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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

        // API rate limiterek definiálása
        RateLimiter::for('api-auth', function(Request $request): Limit{
            // IP cím alapján 5 kérés percenként
            return Limit::perMinute(5)->by($request->ip());
        });
        // Felhasználó alapú rate limiter a feladatok API végpontjaihoz
        RateLimiter::for('api-tasks', function(Request $request){
            // Felhasználó ID vagy IP cím alapján 60 kérés percenként
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
