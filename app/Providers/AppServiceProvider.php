<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Tighten\Ziggy\Ziggy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // Share Ziggy routes ke Inertia
        Inertia::share([
            'ziggy' => function () {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => request()->url(),
                ]);
            },
        ]);
    }
}