<?php

namespace DawPhpValidator\Support\Request\Bags;

class ParameterBag
{
    /**
     * Parameter storage.
     *
     * @var array
     */
    private $parameters;

    /**
     * ParameterBag Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array - Les paramètres
     */
    public function all(): array
    {
        return $this->parameters;
    }
}
