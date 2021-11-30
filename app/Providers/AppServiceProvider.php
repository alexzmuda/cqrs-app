<?php

namespace App\Providers;

use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\LazyCommandRegistry;
use App\Infrastructure\CQRS\LazyQueryRegistry;
use App\Infrastructure\CQRS\QueryRegistry;

use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\JsonResource;
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
        // if ($this->app->isLocal()) {
        //    $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        //    $this->app->register(TelescopeServiceProvider::class);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        $this->app->singleton(
            CommandRegistry::class,
            fn(Application $app) => new LazyCommandRegistry($app)
        );

        $this->app->singleton(
            QueryRegistry::class,
            fn(Application $app) => new LazyQueryRegistry($app)
        );
    }
}