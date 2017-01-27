<?php

namespace DawPhpValidator\Support;

class Request
{
    /**
     * @return array
     */
    public static function getMethodGet()
    {
        return $_GET;
    }

    /**
     * @return array
     */
    public static function getMethodPost()
    {
        return $_POST;
    }
}
