<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        if (Schema::hasTable('settings')) {
            $settings = Setting::all('key', 'value')->keyBy('key')->transform(function ($settings) {
                return $settings->value;
            })->toArray();

            config(['settings' => $settings]);


            config(['app.name' => config('settings.app_name')]);
        }
    }
}
