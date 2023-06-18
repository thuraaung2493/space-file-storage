# Space Storage

**It supports Laravel 9+ and PHP 8.2+**

## Installation

```bash
composer require thuraaung2493/space-file-storage@dev
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
