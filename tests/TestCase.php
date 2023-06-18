<?php

declare(strict_types=1);

namespace Thuraaung\Namespace\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase as BaseTestCase;

final class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [

        ];
    }

    /**
     * @param Application $app
     * @return array<string,class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [

        ];
    }
}
