<?php

namespace DawPhpValidator\Support;

class Request
{
    /**
     * @return array
     */
    public static function methodGet()
    {
        return $_GET;
    }

    /**
     * @return array
     */
    public static function methodPost()
    {
        return $_POST;
    }
}
