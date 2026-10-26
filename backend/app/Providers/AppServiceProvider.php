<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Observers\ProjectObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // You can bind interfaces, singletons, or helpers here if needed.
        // Keeping clean and minimal for now.
    }

    /**
     * Bootstrap any application services.
     *
     * This is the correct place to register model observers in Laravel 11+ and 12+.
     */
    public function boot(): void
    {
        /**
         * Attach the ProjectObserver to the Project model.
         * This automatically listens for created, updated, and deleted events.
         */
        Project::observe(ProjectObserver::class);
    }
}
