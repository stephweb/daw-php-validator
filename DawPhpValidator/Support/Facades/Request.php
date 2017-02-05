<?php

namespace DawPhpValidator\Support\Facades;

/**
 * Facade pour la classe Request
 *
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
final class Request extends Facade
{
    /**
     * @var DawPhpValidator\Support\Request\Request
     */
    protected static $instance;

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'DawPhpValidator\Support\Request\Request';
    }
}
