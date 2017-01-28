<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;

/**
 * Pour retourner des string au format HTML
 */
class HtmlRenderer
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    
	/**
	 * HtmlRender constructor.
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
