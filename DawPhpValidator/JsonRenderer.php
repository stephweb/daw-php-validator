<?php

namespace DawPhpValidator;

/**
 * Pour retourner des string au format Json
 */
class JsonRenderer
{
    /**
     * @var Validator
     */
    private $validator;

	/**
	 * HtmlRenderconstructor.
	 */
	public function __construct(Validator $validator)
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
