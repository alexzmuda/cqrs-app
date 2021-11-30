<?php

namespace App\Modules\Order\Providers;

use App\Infrastructure\CQRS\RegisterCommandHandler;
use App\Infrastructure\CQRS\RegisterQueryHandler;
use App\Modules\Order\Providers\RouteServiceProvider;
use App\Modules\Order\Repositories\EloquentOrderRepository;
use App\Modules\Order\Repositories\Interfaces\OrderRepository;
use App\Modules\Order\Services\CQRS\Handlers\CreateOrderCommandHandler;
use App\Modules\Order\Services\CQRS\Handlers\DestroyOrderCommandHandler;
use App\Modules\Order\Services\CQRS\Handlers\FetchOrdersQueryHandler;
use App\Modules\Order\Services\CQRS\Handlers\FetchOrderByIdQueryHandler;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Order';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'order';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $registerCommandHandler = new RegisterCommandHandler($this->app);
        $registerQueryHandler = new RegisterQueryHandler($this->app);

        ### Commands
        $registerCommandHandler(CreateOrderCommandHandler::class);
        $registerCommandHandler(DestroyOrderCommandHandler::class);

        ### Queries
        $registerQueryHandler(FetchOrdersQueryHandler::class);
        $registerQueryHandler(FetchOrderByIdQueryHandler::class);

        ### Repositories
        $this->app->singleton(OrderRepository::class, EloquentOrderRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}