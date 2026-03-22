<?php

namespace Huddle\Zendesk\Tests;

use Huddle\Zendesk\Providers\ZendeskServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [ZendeskServiceProvider::class];
    }
}
