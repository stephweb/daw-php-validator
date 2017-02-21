<?php

namespace DawPhpValidator\Support\Request;

use DawPhpValidator\Support\Request\Bags\ParameterBag;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
class Request
{
    /**
     * @var array - $_POST
     */
    private $post;

    /**
     * Request Constructor.
     */
    public function __construct()
    {
        $this->post = new ParameterBag($_POST);
    }

    /**
     * @return ParameterBag
     */
    public function getPost()
    {
        return $this->post;
    }
}
