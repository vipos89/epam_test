<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Route;

class StatisticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::matched(
            function () {
                if (!in_array(Route::currentRouteName(), config('statistic.ignored_routes_names'), true)) {
                    Log::channel('custom')->info((Request::path()) . ' ' . (Request::ip()));
                }

            }
        );
    }
}
