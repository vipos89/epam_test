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
        $config  =   $routes = config('statistic');;
        Route::matched(function (){
            $url = URL::current();
            Log::channel('custom')->info((Request::path()).' '.(Request::ip()));
        });
    }
}
