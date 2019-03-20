<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // mb4string
        Schema::defaultStringLength(191);

        // 视图合成器
        \View::composer('layout.sidebar', function ($view){
            $topic = \App\Topic::all();
            $view->with('topics', $topic);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
