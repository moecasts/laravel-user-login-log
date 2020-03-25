<?php

namespace Moecasts\Laravel\UserLoginLog;

use Illuminate\Support\ServiceProvider;

class UserLoginLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            \dirname(__DIR__) . '/config/loginlog.php',
            'loginlog'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        if (\function_exists('config_path')) {
            $this->publishes([
              __DIR__ . '/../config/loginlog.php' => config_path('loginlog.php')
            ], 'laravel-user-login-log-config');
        }

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'laravel-user-login-log-migrations');
    }
}
