<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Support\String\Json;

/**
 * Pour retourner des string au format Json
 */
class JsonRenderer implements RendererInterface
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
