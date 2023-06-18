<?php

declare(strict_types=1);

namespace Thuraaung\SpaceStorage\Contracts;

use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

interface FileStorage
{
    public function clearCache(string $folder, string $fileName): ClientResponse;

    public function display(string $path): Response;

    public function put(string $folder, string $link, ?string $name = null): string;

    public function upload(string $folder, UploadedFile|string $file, ?string $name = null): string;

    public function update(string $oldPath, UploadedFile|string $file): bool;

    public function delete(?string $path): bool;

    public function exists(string $path): bool;
}
