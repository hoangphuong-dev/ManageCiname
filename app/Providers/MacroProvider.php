<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroProvider extends ServiceProvider
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
        Collection::macro('flattenTree', function ($childrenField) {
            $result = collect();

             foreach ($this->items as $item) {
                $result->push($item);

                if ($item->$childrenField instanceof Collection) {
                    $result = $result->merge($item->$childrenField->flattenTree($childrenField));
                }
            }

            return $result;
        });
    }
}
