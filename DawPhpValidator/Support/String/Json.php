<?php

namespace DawPhpValidator\Support\String;

class Json
{
    /**
     * Encoder au format Json
     *
     * @param mixed $value
     * @return string
     */
    public static function encode($value): string
    {
        return json_encode($value);
    }
}
