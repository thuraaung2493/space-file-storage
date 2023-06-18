<?php

declare(strict_types=1);

namespace Thuraaung\SpaceStorage;

use Illuminate\Support\ServiceProvider;
use Thuraaung\SpaceStorage\Contracts\FileStorage;

final class PackageServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public $bindings = [
        FileStorage::class => SpaceStorage::class,
    ];
}
