<?php

namespace Huddle\Zendesk\Tests;

use Huddle\Zendesk\Facades\Zendesk;
use Huddle\Zendesk\Services\NullService;

class ZendeskServiceProviderTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('zendesk-laravel.driver', null);
    }

    public function test_it_merges_default_configuration(): void
    {
        $config = $this->app['config'];

        $this->assertSame(null, $config->get('zendesk-laravel.driver'));
        $this->assertSame(null, $config->get('zendesk-laravel.subdomain'));
        $this->assertSame(null, $config->get('zendesk-laravel.username'));
        $this->assertSame(null, $config->get('zendesk-laravel.token'));
    }

    public function test_it_resolves_a_null_service_when_driver_is_disabled(): void
    {
        $service = $this->app->make('zendesk');

        $this->assertInstanceOf(NullService::class, $service);
        $this->assertSame($service, $service->tickets()->findAll());
    }

    public function test_facade_uses_the_container_binding(): void
    {
        $this->assertInstanceOf(NullService::class, Zendesk::getFacadeRoot());
    }
}
