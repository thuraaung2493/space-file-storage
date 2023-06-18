<?php

declare(strict_types=1);

namespace Thuraaung\SpaceStorage\Exceptions;

use Exception;
use Thuraaung\SpaceStorage\Exceptions\Concerns\HasRender;

final class FileReadException extends Exception
{
    use HasRender;

    public const TITLE = 'File Read Errors!';
}
