<?php
namespace Carlosrgzm\ActivityLog;

use Illuminate\Support\ServiceProvider;


class ActivityLogServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/activitylog.php' => config_path('activitylog.php'),]);
        $this->publishes([__DIR__ . '/migrations' => database_path('migrations'),], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

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


}
