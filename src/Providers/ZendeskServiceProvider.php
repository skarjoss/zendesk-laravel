<?php namespace Huddle\Zendesk\Providers;

use Huddle\Zendesk\Services\NullService;
use Huddle\Zendesk\Services\ZendeskService;
use Illuminate\Support\ServiceProvider;

class ZendeskServiceProvider extends ServiceProvider {

    private const PACKAGE_NAME = 'zendesk-laravel';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider and merge config.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->configPath(), self::PACKAGE_NAME
        );

        $this->app->singleton('zendesk', function () {
            $driver = config('zendesk-laravel.driver', 'api');

            if (is_null($driver) || $driver === 'log') {
                return new NullService($driver === 'log');
            }

            return new ZendeskService;
        });
    }

    /**
     * Bind service to 'zendesk' for use with Facade.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path(sprintf('%s.php', self::PACKAGE_NAME)),
        ]);
    }

    private function configPath()
    {
        return __DIR__.'/../../config/'.self::PACKAGE_NAME.'.php';
    }
}
