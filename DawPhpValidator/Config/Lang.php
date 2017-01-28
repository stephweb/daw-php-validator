<?php

namespace DawPhpValidator\Config;

use DawPhpValidator\Exception\ExceptionHandler;

/**
 * Pour require les fichiers qui sont dans le dossier lang des resources
 */
final class Lang extends SingletonConfig
{
    /**
     * @var Lang
     */
    protected static $instance;

    /**
     * @var array
     */
    private static $require = [];

    /**
     * Pour charger fichier(s) de lang
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws ExceptionHandler
     */
    public function __call(string $method, array $arguments)
    {
        if (!isset(self::$require[$method])) {
            $path = dirname(dirname(dirname(__FILE__))).'/resources/lang/'.$this->getLang().'/'.$method.'.php';
            
            if (file_exists($path)) {
                self::$require[$method] = require_once $path;
            } else {
                throw new ExceptionHandler('Lang file "'.$this->getLang().'" not found.');
            }
        }

        return self::$require[$method];
    }

    /**
     * @return string - Langue choisie dans config
     */
    public function getLang(): string
    {
        static $lang;

        if ($lang === null) {
            $lang = Config::getInstance()->get()['lang'];
        }

        return $lang;
    }
}
