<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;

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
	 * HtmlRenderconstructor.
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
    public function getErrors()
    {
        return json_encode($this->validator->getErrors());
    }
}
