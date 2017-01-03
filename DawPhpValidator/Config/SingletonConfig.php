<?php

namespace DawPhpValidator\Config;

/**
 * Class parent des classes de config
 */
abstract class SingletonConfig
{
    /**
     * Pour charger fichier(s)
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    abstract public function __call($method, array $arguments);

    /**
     * Singleton
     *
     * @return mixed
     */
    final public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * SingletonConfig constructor.
     * private - car n'est pas autorisé à etre appelée de l'extérieur
     */
    final private function __construct()
    {

    }

    /**
     * private - empêcher l'occurrence d'être cloné
     */
    final private function __clone()
    {

    }

    /**
     * private - empêcher d'être sérialisé
     */
    final private function __wakeup()
    {

    }

}