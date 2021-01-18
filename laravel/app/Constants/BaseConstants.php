<?php

namespace App\Constants;

use ReflectionClass;

/**
 * Class BaseConstants.
 */
abstract class BaseConstants
{
    /**
     * Return an array of all the constants in the calling class.
     */
    public static function getConstants(): array
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }
}
