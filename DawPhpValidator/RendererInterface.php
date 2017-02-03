<?php

namespace DawPhpValidator;

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
