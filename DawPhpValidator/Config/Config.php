<?php

namespace DawPhpValidator\Config;

use DawPhpValidator\Exception\ExceptionHandler;

/**
 * Pour require les fichiers qui sont dans le dossier de config
 */
class Config extends SingletonConfig
{
    /**
     * @var Config
     */
    protected static $instance;

    /**
     * @var array
     */
    private static $require = [];

    /**
     * @var array
     */
    private static $config = [];

    /**
     * Pour charger fichier(s) de config
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws ExceptionHandler
     */
    public function __call($method, array $arguments)
    {
        if ($method === 'config' && self::$config !== []) {
            return self::$config;
        }

        if (!isset(self::$require[$method])) {
            $path = dirname(dirname(dirname(__FILE__))).'/config/'.$method.'.php';
            
            if (file_exists($path)) {
                self::$require[$method] = require_once $path;
            } else {
                throw new ExceptionHandler('Config file "'.$method.'" not foud.');
            }
        }

        return self::$require[$method];
    }


    /**
     * @param array $config
     */
    public static function set(array $config)
    {
        self::$config = $config;
    }

}