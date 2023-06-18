<?php

declare(strict_types=1);

namespace Thuraaung\SpaceStorage;

use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\UnableToCheckDirectoryExistence;
use League\Flysystem\UnableToCheckFileExistence;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Thuraaung\ApiHelpers\Http\Enums\Status;
use Thuraaung\SpaceStorage\Contracts\FileStorage;
use Thuraaung\SpaceStorage\Exceptions\FileReadException;
use Thuraaung\SpaceStorage\Exceptions\FileTypeException;
use Thuraaung\SpaceStorage\Exceptions\FileUploadException;

final class SpaceStorage implements FileStorage
{
    public function clearCache(string $folder, string $fileName): ClientResponse
    {
        return Http::asJson()->delete(
            config('filesystems.space.cdn_endpoint') . '/cache',
            [
                'files' => ["{$folder}/{$fileName}"],
            ]
        );
    }

    public function display(string $path): HttpResponse
    {
        if ( ! $this->exists($path)) {
            throw new NotFoundHttpException('File not found!');
        }
        return $this->makeFileResponse($path);
    }

    public function put(string $folder, string $link, ?string $name = null): string
    {
        $name = $name ?? $this->generateFileName();

        Storage::put(
            path: $folder . '/' . $name,
            contents: $this->getContents($link),
        );

        return $folder . '/' . $name;
    }

    public function upload(string $folder, UploadedFile|string $file, ?string $name = null): string
    {
        $fileName = $name ?? $this->generateFileName($file);

        if ($file instanceof UploadedFile) {
            return $this->putFileAs(
                folder: $folder,
                file: $file,
                name: $fileName,
            );
        }

        return $this->put($folder, $file, $fileName);
    }

    public function update(string $oldPath, UploadedFile|string $file): bool
    {
        if ($file instanceof UploadedFile) {
            [$folder, $name] = explode('/', $oldPath);

            $this->putFileAs(
                folder: $folder,
                file: $file,
                name: $name,
            );

            return true;
        }

        return Storage::put(
            path: $oldPath,
            contents: $this->getContents($file),
        );
    }

    public function delete(?string $path): bool
    {
        if ($path && $this->exists($path)) {
            return Storage::delete($path);
        }

        return false;
    }

    public function exists(string $path): bool
    {
        try {
            return Storage::exists($path);
        } catch (UnableToCheckDirectoryExistence) {
            return false;
        } catch (UnableToCheckFileExistence) {
            return false;
        }
    }

    private function getContents(string $link): string
    {
        if ( ! ($contents = file_get_contents($link))) {
            throw new FileReadException(
                message: "Could not load file from link {$link}",
                code: Status::BAD_REQUEST->value,
            );
        }

        return $contents;
    }

    /**
     * @throws FileUploadException
     */
    private function putFileAs(string $folder, UploadedFile $file, string $name): string
    {
        $path = Storage::putFileAs(
            path: $folder,
            file: $file,
            name: $name,
        );

        if ( ! $path) {
            throw new FileUploadException(
                message: 'File does not upload!',
                code: Status::NOT_ACCEPTABLE->value
            );
        }

        return $path;
    }

    private function makeFileResponse(string $path): HttpResponse
    {
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $response = Response::make($file, 200);

        if (false === $type) {
            throw new FileTypeException(
                message: 'File type does not support!',
                code: Status::BAD_REQUEST->value,
            );
        }

        return $response->header('Content-Type', $type)->setMaxAge(604800)->setPrivate();
    }

    private function generateFileName(UploadedFile|string|null $file = null): string
    {
        if (null === $file || is_string($file)) {
            return (string) Str::uuid() . '.png';
        }

        return (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
    }
}
