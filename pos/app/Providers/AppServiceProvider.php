<?php

namespace App\Providers;

use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        // if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
        //     URL::forceScheme('https');
        // }
        //setting language
        if(isset($_COOKIE['language'])) {
            \App::setLocale($_COOKIE['language']);
        } else {
            \App::setLocale('en');
        }
        //get general setting value
        $general_setting = DB::table('general_settings')->latest()->first();
        View::share('general_setting', $general_setting);
        config(['staff_access' => $general_setting->staff_access, 'date_format' => $general_setting->date_format, 'currency' => $general_setting->currency, 'currency_position' => $general_setting->currency_position]);

        $alert_product = DB::table('products')->where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->count();
        $two_months_from_now = Carbon::now()->addDays(60)->toDateString();
        $alert_expired_product = DB::table('products')->where('is_active', true)->whereDate('expiry_date', '<=', $two_months_from_now)->count();
        View::share([
            'alert_product' => $alert_product,
            'alert_expired_product' => $alert_expired_product
        ]);
        Schema::defaultStringLength(191);
    }
}
