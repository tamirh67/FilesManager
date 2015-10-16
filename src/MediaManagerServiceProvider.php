<?php

namespace tamirh67\MediaManager;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'MediaManager');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'MediaManager');

        $this->publishes([
            __DIR__.'/resources/assets/css' => public_path('/css')
        ], 'css');

        $this->publishes([
            __DIR__.'/resources/assets/js' => public_path('/js')
        ], 'js');

        $this->publishes([
            __DIR__.'/resources/assets/img' => '/database/migrations'
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/migrations' => public_path('/img')
        ], 'images');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MediaManager', function() {
            return new MediaManager;
        });

        $this->app->make('tamirh67\MediaManager\MediaController');

    }
}
