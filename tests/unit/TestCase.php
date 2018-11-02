<?php

namespace Laralog\Laralog\Tests\Unit;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Laralog\Laralog\LaralogServiceProvider'];
    }
}
