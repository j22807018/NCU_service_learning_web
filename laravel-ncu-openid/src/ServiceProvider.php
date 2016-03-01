<?php
namespace NCU\OpenID;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('NCU\NetID', function ($app) {
            $netid = new NetID;
            $netid->setting(config('netid.host_domain'),
                config('netid.prefix'),
                config('netid.allowed_roles'));
            return $netid;
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configFile = __DIR__ . '/../config/netid.php';
        $this->mergeConfigFrom($configFile, 'netid');
        $this->publishes([
            $configFile => config_path('netid.php'),
        ]);
    }

}
