<?php

namespace tamirh67\FilesManager;

use Illuminate\Support\ServiceProvider;

class FilesManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'FilesManager');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'FilesManager');

        $this->publishes([
            __DIR__.'/resources/assets/css' => public_path('/css')
        ], 'css');

        $this->publishes([
            __DIR__.'/resources/assets/js' => public_path('/js')
        ], 'js');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/resources/assets/img' => public_path('/img')
        ], 'images');

        $this->publishes([
            __DIR__ . '/config/filesmanager.php' => config_path('filesmanager.php', 'config'),
        ], 'filesmanager_config');

        // create directories
        if(!file_exists(public_path('/img/thumbs'))) {
            mkdir(public_path('/img/thumbs'));
        }

        if(!file_exists(storage_path('/app/uploads'))) {
            mkdir(storage_path('/app/uploads'));
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FilesManager', function() {
            return new FilesManager;
        });

        $this->app->make('tamirh67\FilesManager\FilesController');

    }
}
