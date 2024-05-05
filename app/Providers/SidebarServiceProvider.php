<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['components.sidebar', 'layouts.nav'], function ($view) {
            $categories = DB::table('categories')->orderBy('name')->get();

            $view->with(['categories' => $categories]);
        });
    }
}
