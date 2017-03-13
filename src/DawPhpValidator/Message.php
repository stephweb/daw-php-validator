<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;

/**
 * Pour retourner les messages du Validator
 *
 * @link     https://www.devandweb.fr/packages/daw-php-validator
 * @link     https://www.devandweb.com/packages/daw-php-validator
 * @link     https://github.com/stephweb/daw-php-validator
 * @author   stephweb <stephweb@live.fr>
 * @license  MIT License
 */
final class Message
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Message constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toHtml();
    }

    /**
     * @return string - La réponse au format HTML
     */
    public function toHtml(): string
    {
        $htmlRenderer = new HtmlRenderer($this->validator);

        if ($this->validator->isValid()) {
            return $htmlRenderer->getSuccess();
        }

        return $htmlRenderer->getErrors();
    }

    /**
     * @return string - La réponse au format JSON
     */
    public function toJson(): string
    {
        $jsonRenderer = new JsonRenderer($this->validator);

        if ($this->validator->isValid()) {
            return $jsonRenderer->getSuccess();
        }

        return $jsonRenderer->getErrors();
    }
}