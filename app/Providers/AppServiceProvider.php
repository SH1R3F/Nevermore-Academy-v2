<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
    public function boot(Guard $auth)
    {

        URL::defaults(['locale' => app()->getLocale()]);

        Schema::defaultStringLength(191);

        // User bootstrap pagination
        Paginator::useBootstrap();

        // Pass notifications to navbar
        View::composer('layouts.navbar', fn ($view) => $view->with('notifications', $auth->user()->unreadNotifications));

        // Create blade directive for role 
        Blade::directive('role', function ($role) {
            return "<?php if(Auth::check() && Auth::user()->hasRole($role)): ?>";
        });
        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });
    }
}
