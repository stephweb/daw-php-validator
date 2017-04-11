<?php

namespace DawPhpValidator\Config;

use DawPhpValidator\Contracts\Config\ConfigInterface;

/**
 * Pour require fichier(s) qui sont dans le dossier de config
 *
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
final class Config extends SingletonConfig implements ConfigInterface
{
    /**
     * @var Config
     */
    protected static $instance;
    
    /**
     * @var array
     */
    private static $config = [];

    /**
     * @param array $config
     */
    public static function set(array $config)
    {
        self::$config = $config;
    }

    /**
     * @return array
     */
    public static function get(): array
    {
        static $config;

        if ($config === null) {
            if (self::$config !== []) {
                $config = self::$config;
            } else {
                $config = require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
            }
        }

        return $config;
    }
}
