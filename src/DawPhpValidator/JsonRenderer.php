<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Support\String\Json;

/**
 * Pour retourner des string au format Json
 *
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   Stephen Damian <contact@devandweb.fr>
 * @license  MIT License
 */
final class JsonRenderer implements RendererInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

	/**
	 * JsonRenderer constructor.
     *
     * @param ValidatorInterface $validator
     */
	public function __construct(ValidatorInterface $validator)
	{
		$this->validator = $validator;
	}

    /**
     * @return string - Les erreurs à afficher
     */
    public function getErrors(): string
    {
        $json = '';

        if (!$this->validator->isValid()) {
            $json .= Json::encode($this->validator->getErrors());
        }

        return $json;
    }

    /**
     * @return string - Le message de confirmation
     */
    public function getSuccess(): string
    {
        $json = '';

        if ($this->validator->isValid()) {
            $json .= Json::encode($this->validator->getSuccess());
        }

        return $json;
    }
}
