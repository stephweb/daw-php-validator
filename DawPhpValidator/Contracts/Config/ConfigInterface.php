<?php

namespace DawPhpValidator\Contracts\Config;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
interface ConfigInterface
{
    /**
     * @param array $config
     */
    public static function set(array $config);

    /**
     * @return array
     */
    public static function get(): array;
}
