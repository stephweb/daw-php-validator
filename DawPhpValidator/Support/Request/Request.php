<?php

namespace DawPhpValidator\Support\Request;

use DawPhpValidator\Support\Request\Bags\ParameterBag;

class Request
{
    /**
     * $_POST
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
