<?php

namespace ThallesTeodoro\BaseAdmin;

use Illuminate\Support\ServiceProvider;

class BaseAdminServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'baseadmin');

        $this->publishes([
            __DIR__.'/config/adminlte.php' => config_path('adminlte.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/views/' => resource_path('views/')
        ], 'views');

        $this->publishes([
            __DIR__.'/routes' => base_path('routes/')
        ], 'routes');

        $this->app->singleton(
            'ThallesTeodoro\BaseAdmin\App\Interfaces\RepositoryInterface',
            'ThallesTeodoro\BaseAdmin\App\Repositories\Repository'
        );

        $this->app->singleton(
            'ThallesTeodoro\BaseAdmin\App\Interfaces\UserRepositoryInterface',
            'ThallesTeodoro\BaseAdmin\App\Repositories\UserRepository'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registre()
    {

    }
}
