<?php

namespace DawPhpValidator\Support\String;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
class Str
{
    /**
     * Pour remplacer format snake_case par format camelCase 
     *
     * @param string $snake_case
     * @return string
     */
    public static function convertSnakeCaseToCamelCase(string $snake_case): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $snake_case)));
    }
}
