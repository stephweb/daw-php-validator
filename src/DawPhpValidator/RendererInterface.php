<?php

namespace DawPhpValidator;

/**
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
