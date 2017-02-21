<?php

namespace DawPhpValidator\Support\String;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
class Json
{
    /**
     * Encoder au format Json
     *
     * @param mixed $value
     * @return string
     */
    public static function encode($value): string
    {
        return json_encode($value);
    }
}
