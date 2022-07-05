<?php

namespace Libaro\Bread\Tests;

use Libaro\Bread\BreadServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            BreadServiceProvider::class,
        ];
    }
}
