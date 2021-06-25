<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class validateInputs extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       require_once app_path() . '/helpers/validation.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
