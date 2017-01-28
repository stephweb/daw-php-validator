<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Support\String\Json;

/**
 * Pour retourner des string au format Json
 */
class JsonRenderer
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
     * @return string - les erreurs à afficher
     */
    public function getErrors(): string
    {
        return Json::encode($this->validator->getErrors());
    }
}
