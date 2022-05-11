<?php

namespace Sunilyadav\Generator;

use Illuminate\Support\ServiceProvider;
use Sunilyadav\Generator\Commands\ProductGeneratorCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            ProductGeneratorCommand::class,
        ]);
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
