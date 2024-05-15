<?php

namespace App\Util\Exception;

use Spatie\Enum\Enum;

/**
 * @method static self VALIDATION_EXCEPTION()
 * @method static self USER_NOT_FOUND()
 * @method static self GROUP_NOT_FOUND()
 */
class ErrorCodes extends Enum
{
    public const VALIDATION_EXCEPTION = 1101;

    public const USER_NOT_FOUND = 1201;

    public const  GROUP_NOT_FOUND = 1202;
}
