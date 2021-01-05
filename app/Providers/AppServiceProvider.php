<?php

namespace App\Providers;

use App\Services\Stocks\StockChecker;
use BotMan\BotMan\BotMan;
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
        $this->app->alias('botman', BotMan::class);
        $this->app->singleton(StockChecker::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
