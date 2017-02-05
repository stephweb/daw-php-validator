<?php

namespace DawPhpValidator\Support\Facades;

/**
 * Classe parent de toute les Façades
 *
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
abstract class Facade
{
    /**
     * @return string
     */
    abstract protected static function getFacadeAccessor();

    /**
     * @param string $method - Nom de la method à appeler
     * @param array $arguments - Paramètres dans method
     * @return mixed
     */
    final public static function __callStatic(string $method, array $arguments)
    {
        if (static::$instance === null) {            
            static::$instance = self::getFacadeRoot();
        }

        return call_user_func_array([static::$instance, $method], $arguments);
    }

    /**
     * @return mixed
     */
    final public static function getFacadeRoot()
    {
        $class = static::getFacadeAccessor();
        
        return new $class();
    }
}
