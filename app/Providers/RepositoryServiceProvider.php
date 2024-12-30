<?php

namespace App\Providers;

use App\Repositories\Designation\DesignationEloquent;
use App\Repositories\Designation\DesignationInterface;
use App\Repositories\Routelist\RoutelistEloquent;
use App\Repositories\Routelist\RoutelistInterface;
use App\Repositories\Setting\SettingEloquent;
use App\Repositories\Setting\SettingInterface;
use App\Repositories\User\PermissionEloquent;
use App\Repositories\User\PermissionInterface;
use App\Repositories\User\RoleEloquent;
use App\Repositories\User\RoleInterface;
use App\Repositories\User\UserEloquent;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserInterface::class, UserEloquent::class);
        $this->app->singleton(RoleInterface::class, RoleEloquent::class);
        $this->app->singleton(PermissionInterface::class, PermissionEloquent::class);
        $this->app->singleton(RoutelistInterface::class, RoutelistEloquent::class);
        $this->app->singleton(DesignationInterface::class, DesignationEloquent::class);
        $this->app->singleton(SettingInterface::class, SettingEloquent::class);
    }
}
