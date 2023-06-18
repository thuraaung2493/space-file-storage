# Space Storage

**It supports Laravel 9+ and PHP 8.2+**

## Installation

```bash
composer require thuraaung2493/space-file-storage@dev
```

## Configuration

Copy the following config to `config/filesystems.php` file and

```php
  'space' => [
    'driver' => 's3',
    'key' => env('SPACE_ACCESS_KEY_ID'),
    'secret' => env('SPACE_SECRET_ACCESS_KEY'),
    'region' => env('SPACE_DEFAULT_REGION'),
    'bucket' => env('SPACE_BUCKET'),
    'cdn_endpoint' => env('SPACE_CDN_ENDPOINT'),
    'folder' => env('SPACE_FOLDER'),
    'url' => env('SPACE_URL'),
    'endpoint' => env('SPACE_ENDPOINT'),
    'use_path_style_endpoint' => env('SPACE_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => true,
  ],
```

add these env variables to `.env` file.

```env
SPACE_ACCESS_KEY_ID=
SPACE_SECRET_ACCESS_KEY=
SPACE_DEFAULT_REGION=
SPACE_BUCKET=
SPACE_CDN_ENDPOINT=
SPACE_ENDPOINT=
SPACE_USE_PATH_STYLE_ENDPOINT=
```

## Usage

```php

// Facades
use Thuraaung\SpaceStorage\Facades\SpaceStorage

SpaceStorage::clearCache($folder, $fileName);
SpaceStorage::display($path);
SpaceStorage::upload($folder, $file);
SpaceStorage::put($folder, $link);
SpaceStorage::update($oldPath, $file);
SpaceStorage::exists($path);
SpaceStorage::delete($path);

// Or

use Thuraaung\SpaceStorage\SpaceStorage;

$storage = new SpaceStorage();
$storage->clearCache($folder, $fileName);
$storage->display($path);
$storage->put($folder, $link);
$storage->upload($folder, $file);
$storage->update($oldPath, $file);
$storage->exists($path);
$storage->delete($path);
```

## Test

```bash
  composer test
```

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
