<?php

namespace DawPhpValidator\Support\String;

/**
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
class Str
{
    /**
     * Cache de camel-cased words.
     *
     * @var array
     */
    private static $camelCache = [];
    
    /**
     * Pour remplacer format snake_case par format camelCase
     *
     * @param string $value - snake_case
     * @return string
     */
    public static function convertSnakeCaseToCamelCase(string $value): string
    {
        if (isset(self::$camelCache[$value])) {
            return self::$camelCache[$value];
        }

        return self::$camelCache[$value] = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
    }
}
