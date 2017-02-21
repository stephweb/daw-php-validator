<?php

namespace DawPhpValidator\Support\Request\Bags;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
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
