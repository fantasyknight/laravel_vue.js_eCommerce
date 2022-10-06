<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

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
        return rescue(function () {
            config(['setting' => Setting::all()->pluck('value', 'meta')->toArray()]);
        });

        // try {
        //     config(['setting' => DB::table('settings')->get()->pluck('value', 'meta')->toArray()]);

        // } catch (Exception $e) {

        // }
    }
}
