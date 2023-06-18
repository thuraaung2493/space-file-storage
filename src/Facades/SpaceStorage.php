<?php

declare(strict_types=1);

namespace Thuraaung\SpaceStorage\Facades;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Thuraaung\SpaceStorage\SpaceStorage as BaseSpaceStorage;

/**
 * @method static Response clearCache(string $folder, string $fileName)
 * @method static HttpResponse display(string $path)
 * @method static string put(string $folder, string $link, string|null $name)
 * @method static string upload(string $folder, UploadedFile|string $file, string|null $name)
 * @method static bool update(string $oldPath, UploadedFile|string $file)
 * @method static bool delete(?string $path)
 * @method static bool exists(string $path)
 *
 * @see BaseSpaceStorage
 */
final class SpaceStorage extends Facade
{
    /**
     * @return class-string
     */
    protected static function getFacadeAccessor(): string
    {
        return BaseSpaceStorage::class;
    }
}
