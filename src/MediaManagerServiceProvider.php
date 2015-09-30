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

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'media-manager');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'media-manager');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('media-manager', function() {
            return new MediaManager;
        });

        $this->app->make('tamirh67\MediaManager\MediaController');

    }
}
