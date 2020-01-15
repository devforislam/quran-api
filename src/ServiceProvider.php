<?php

namespace DevForIslam\QuranApi;

use Fruitcake\Cors\HandleCors;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
     /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->rootPath = realpath(__DIR__.'/../');
        $this->mergeConfigFrom(
            $this->rootPath . '/config/quran.php', 'quran'
        );
        
        $this->enableCors();
    }

    public function boot()
    {
        $this->loadMigrationsFrom($this->rootPath .'/database/migrations');
        $this->loadRoutesFrom($this->rootPath . '/routes/api.php');
        $this->publishAssets();
    }

    private function publishAssets()
    {
        $this->publishes([
            $this->rootPath . '/config/quran.php' => config_path('quran.php'),
        ], 'quran-api');
    }

    private function enableCors()
    {
        if (config('quran.enable_cors')) {
            config(['cors.paths' => ['api/*']]);
            $this->app->make(\Illuminate\Contracts\Http\Kernel::class)->pushMiddleware(HandleCors::class);
        }
    }

}