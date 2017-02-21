<?php

namespace DawPhpValidator;

/**
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
Interface RendererInterface
{
    /**
     * @return string - Les erreurs à afficher
     */
    public function getErrors(): string;

    /**
     * @return string - Le message de confirmation
     */
    public function getSuccess(): string;
}
