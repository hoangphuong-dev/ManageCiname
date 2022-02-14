<?php

namespace App\Providers;

use App\Models\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_ENV') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        
        // Register `filters` macro
        Builder::macro('filters', function (Filters $filters) {
            return $filters->getQuery($this);
        });
    }
}
