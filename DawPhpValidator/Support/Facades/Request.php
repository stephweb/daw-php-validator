<?php

namespace DawPhpValidator\Support\Facades;

/**
 * Facade pour la class Request
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
