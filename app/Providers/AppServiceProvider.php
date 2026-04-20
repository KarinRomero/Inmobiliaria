<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Propiedad;
use App\Observers\PropiedadObserver;

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
        Propiedad::observe(PropiedadObserver::class);
    }
}
