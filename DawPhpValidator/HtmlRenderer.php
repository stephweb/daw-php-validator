<?php

namespace DawPhpValidator;

class HtmlRenderer
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
        $html = '';

        if (count($this->validator->getErrors()) > 0) {
            $html .= '<ul>';
            foreach ($this->validator->getErrors() as $error)  {
                $html .= '<li>'.$error.'</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }
}