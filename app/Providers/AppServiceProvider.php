<?php

namespace App\Providers;

use App\Charts\SampleChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Helper\Helper;

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
     * @param SampleChart $chart
     * @return void
     */
    public function boot()
    {
        $general_setting = DB::table('general_settings')->latest()->first();

        View::share(compact('general_setting'));

    }
}
