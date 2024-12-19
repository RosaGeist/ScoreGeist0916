<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.menu', function ($view) {
            $user = Auth::user();
            $gruposInscritos = $user ? $user->gruposAsignados()->get() : collect();
            $view->with('gruposInscritos', $gruposInscritos);
        });
    }
}
