<?php

namespace TaylorNetwork\MakeHTML;

use Illuminate\Support\ServiceProvider;

class MakeHTMLProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'config/makehtml.php' => config_path('makehtml.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'config/makehtml.php', 'makehtml'
        );
    }
}
