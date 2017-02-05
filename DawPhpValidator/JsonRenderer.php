<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Support\String\Json;

/**
 * Pour retourner des string au format Json
 *
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
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
        $html = '';

        if (!$this->validator->isValid()) {
            $html .= Json::encode($this->validator->getErrors());
        }

        return $html;
    }

    /**
     * @return string - Le message de confirmation
     */
    public function getSuccess(): string
    {
        $html = '';

        if ($this->validator->isValid()) {
            $html .= Json::encode($this->validator->getSuccess());
        }

        return $html;
    }
}
