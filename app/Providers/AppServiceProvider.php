<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
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
        // URL::forceRootUrl(config('app.url')); // https://docs.cashup.id
        // URL::forceScheme('https');

        View::share('merchantMid', Cache::remember('merchant_mid_125', now()->addMinutes(10), function () {
            return DB::connection('cdcp')
                ->table('merchant_mid')
                ->where('merchant_id', 125)
                ->orderByDesc('id')
                ->value('mid');
        }));
    }
}
