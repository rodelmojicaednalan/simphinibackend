<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {        
        #Admin Repository
        $this->app->bind('App\Repositories\Admin\ClientRepository', 'App\Repositories\Admin\ClientRepositoryEloquent');
        $this->app->bind('App\Repositories\Admin\AdminUserRepository', 'App\Repositories\Admin\AdminUserRepositoryEloquent');
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
