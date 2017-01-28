<?php

namespace DawPhpValidator\Contracts\Config;

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
