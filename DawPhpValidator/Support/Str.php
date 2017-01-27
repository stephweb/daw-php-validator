<?php

namespace DawPhpValidator\Support;

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
