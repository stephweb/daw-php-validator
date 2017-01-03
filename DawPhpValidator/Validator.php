<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Config\Lang;
use DawPhpValidator\Exception\ExceptionHandler;

/**
 * Pour vérifications des données
 */
class Validator implements ValidatorInterface
{
    /**
     * Erreurs dans un Array associatif
     *
     * @var array
     */
    private $errors = [];

    /**
     * Pour permettre de par exemple dans le controller de faire ceci : 'key' => ['label'=>'Mots clés', ...], ...
     * afficher la "value de 'label'" au lieu du "ucfirst(name) de l'input"
     *
     * @var string
     */
    private $label;

    /**
     * Name du input
     *
     * @var string
     */
    private $input;

    /**
     * Valeur des rules qu'on passe à un input
     *
     * @var mixed
     */
    private $value;

    /**
     * POST ou GET - Est à POST par defaut
     *
     * @var null|string
     */
    private $requestHttp;

    /**
     * Langue choisie dans config/config.php
     *
     * @var string
     */
    private $langValidation;

    /**
     * Attributs de validation personnalisés
     *
     * @var array
     */
    private $attributes;

    /**
     * @const string
     */
    const REGEX_TEL = '/^[0-9-+(),;._ \/]{4,20}$/';

    /**
     * @const string
     */
    const REGEX_SLUG = '/^[a-z0-9\-]+$/';

    /**
     * @const string
     */
    const REGEX_ALPHA = '/^[a-z]+$/i';

    /**
     * @const string
     */
    const REGEX_INTEGER = '/^[0-9]+$/';

    /**
     * @const string
     */
    const REGEX_ALPHA_NUMERIC = '/^[a-z0-9]+$/i';

    /**
     * @const string
     */
    const REGEX_DATE_TIME = '#^\d{2}/\d{2}/\d{4} \d{2}:\d{2}$#';

    /**
     * @const string
     */
    const REGEX_DATE = '#^\d{2}/\d{2}/\d{4}$#';

    /**
     * @const string
     */
    const REGEX_POSTALE_CODE = '/^[0-9]{5}$/';

    /**
     * @const string
     */
    const REGEX_CHARACTERS_PROHIBITED_NAME_FILE = '/[\/:*?"<>|\\\\ ÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰]/';

    /**
     * Validator constructor.
     *
     * @param null $requestHttp
     */
    public function __construct($requestHttp=null)
    {
        $this->requestHttp = ($requestHttp != null) ? $requestHttp : $_POST;

        $this->langValidation = Lang::getInstance()->validation();

        $this->attributes = $this->langValidation['attributes'];
    }

    /**
     * Vérification des données envoyées
     *
     * @param array $array
     * @throws ExceptionHandler
     */
    public function rules(array $array)
    {
        foreach ($array as $input => $rules) {
            $this->input = $input;
            
            $this->setLabel($rules);

            if (is_array($rules)) {
                foreach ($rules as $rule => $value) {
                    if ($rule != 'label') {
                        $this->value = $value;

                        $methodVerify = 'verify'.$this->forReplaceUnderscoreToCamelCase($rule);
                        if (!method_exists($this, $methodVerify)) throw new ExceptionHandler('Rule "'.$rule.'" not exist.');
                        $this->$methodVerify();
                    }
                }
            }
        }
    }

    /**
     * @param mixed $rules
     */
    private function setLabel($rules)
    {
        if (isset($rules['label'])) {
            $this->label = $rules['label'];
        } elseif (array_key_exists($this->input, $this->attributes)) {
            $this->label = $this->attributes[$this->input];
        } else {
            $this->label = ucfirst($this->input);
        }
    }

    /**
     * Pour remplacer format snake_case par format camelCase 
     *
     * @param string $withUnderscore
     * @return string
     */
    private function forReplaceUnderscoreToCamelCase($withUnderscore)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $withUnderscore)));
    }

    /**
     * Vérifier que valeur entrée dans le champ est bien alphabétique
     */
    private function verifyAlpha()
    {
        if ($this->value === true && !preg_match(self::REGEX_ALPHA, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('alpha');
        }
    }

    /**
    * Vérifier que valeur entrée dans le champ est bien alphanumérique
    */
    private function verifyAlphaNumeric()
    {
        if ($this->value === true && !preg_match(self::REGEX_ALPHA_NUMERIC, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('alpha_numeric');
        }
    }

    /**
     * Vérifier que valeur est entrée entre 2 valeurs spécifiées
     *
     * $this->value - (array numeroté). Valeur doit etre entre $this->value[0] (valeur min) et $this->value[1] (valeur max)
     */
    private function verifyBetween()
    {
        if ($this->requestHttp[$this->input] < $this->value[0] OR $this->requestHttp[$this->input] > $this->value[1]) {
            $this->errors[$this->input] = $this->pushError('between', $this->value);
        }
    }

    /**
     * Pour obliger 2 valeur à être égales
     */
    private function verifyConfirm()
    {
        if ($this->value[0] != $this->value[1]) {
            $this->errors[$this->input] = $this->pushError('confirm');
        }
    }

    /**
     * Champ doit obligatoirement rester vide
     */
    private function verifyEmpty()
    {
        if ($this->requestHttp[$this->input] != '') {
            $this->errors[$this->input] = $this->pushError('empty');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'une date
     */
    private function verifyFormatDate()
    {
        if ($this->value === true && !preg_match(self::REGEX_DATE, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_date');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'une date/heure
     */
    private function verifyFormatDateTime()
    {
        if ($this->value === true && !preg_match(self::REGEX_DATE_TIME, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_date_time');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'un Email
     */
    private function verifyFormatEmail()
    {
        if ($this->value === true && !filter_var($this->requestHttp[$this->input], FILTER_VALIDATE_EMAIL) == true) {
            $this->errors[$this->input] = $this->pushError('format_email');
        }
    }

    /**
     * Verifier que valeur entrée est bien au format d'une adresse IP
     */
    private function verifyFormatIp()
    {
        if ($this->value === true && !filter_var($this->requestHttp[$this->input], FILTER_VALIDATE_IP)) {
            $this->errors[$this->input] = $this->pushError('format_ip');
        }   
    }

    /**
     * Verif carractères format name fichier
     */
    private function verifyFormatNameFile()
    {
        if ($this->value === true && preg_match(self::REGEX_CHARACTERS_PROHIBITED_NAME_FILE, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_name_file');
        }
    }

    /**
     * Verif carractères format name fichier
     */
    private function verifyFormatPostalCode()
    {
        if ($this->value === true && !preg_match(self::REGEX_POSTALE_CODE, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_postal_code');
        }
    }
    
    /**
     * Vérifier que valeur entrée est bien celui d'un slug
     */
    private function verifyFormatSlug()
    {
        if ($this->value === true && !preg_match(self::REGEX_SLUG, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_slug');
        }
    }

    /**
     * Vérifier que valeur entrée est bien celui d'une URL
     */
    private function verifyFormatUrl()
    {
        if ($this->value === true && !filter_var($this->requestHttp[$this->input], FILTER_VALIDATE_URL)) {
            $this->errors[$this->input] = $this->pushError('format_url');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'un numéro de téléphone
     */
    private function verifyFormatTel()
    {
        if ($this->value === true && !preg_match(self::REGEX_TEL, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_tel');
        }
    }

    /**
     * Vérifier que valeur entrée dans le champ est bien un entier
     */
    private function verifyInteger()
    {
        if ($this->value === true && !preg_match(self::REGEX_INTEGER, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('integer');
        }
    }

    /**
     * Vérifier si donnée envoyés est dans un array
     */
    private function verifyInArray()
    {
        if (!in_array($this->requestHttp[$this->input], $this->value)) {
            $this->errors[$this->input] = $this->pushError('in_array');
        }
    }

    /**
     * Nombre de caractères maximum autorisés dans champ
     */
    private function verifyMax()
    {
        if (isset($this->requestHttp[$this->input]) && mb_strlen($this->requestHttp[$this->input]) > $this->value) {
            $this->errors[$this->input] = $this->pushError('max', $this->value);
        }
    }

    /**
     * Nombre de caractères minimum autorisés dans champ
     */
    private function verifyMin()
    {
        if (isset($this->requestHttp[$this->input]) && mb_strlen($this->requestHttp[$this->input]) < $this->value) {
            $this->errors[$this->input] = $this->pushError('min', $this->value);
        }
    }

    /**
     * Verifier que valeur entrée n'est pas au format d'un regex spécifique
     */
    private function verifyNoRegex()
    {
        if (preg_match($this->value, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('no_regex', $this->value);
        }
    }
    
    /**
     * Verifier que valeur entrée est bien au format d'un regex spécifique
     */
    private function verifyRegex()
    {
        if (!preg_match($this->value, $this->requestHttp[$this->input])) {
            $this->errors[$this->input] = $this->pushError('regex', $this->value);
        }
    }

    /**
     * Champ doit obligatoirement etre remplis
     */
    private function verifyRequired()
    {
        if ($this->value === true && !array_key_exists($this->input, $this->requestHttp) OR $this->requestHttp[$this->input] == '') {
            $this->errors[$this->input] = $this->pushError('required');
        }
    }

    /**
     * Si il y a une erreur
     *
     * @param string $key - Key dans tableaux inclut dans app/resources/lang...
     * @param null|string $value - Pour éventuellemnt {value} dans tableaux inclut dans app/resources/lang...
     * @return string
     */
    private function pushError($key, $value=null)
    {
        $errorMessage = str_replace('{field}', $this->label, $this->langValidation[$key]);

        if ($value !== null) {
            if (is_array($value)) {  // utile pour 'between'
                $i = 0;
                foreach ($value as $v_null) {
                    $errorMessage = str_replace('{value_'.$i.'}', $value[$i], $errorMessage);
                    $i++;
                }
            } else {
                $errorMessage = str_replace('{value}', $value, $errorMessage);
            }
        }

        return $errorMessage;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $input
     * @param string $error
     */
    public function addErrorWithInput($input, $error)
    {
        $this->errors[$input] = $error;
    }

    /**
     * Pour éventuellemnt ajouter des erreurs "à la volé" selon éventuels traitements
     *
     * @param string $error
     */
    public function addError($error)
    {
        $this->errors[$this->input] = $error;
    }

    /**
     * @return bool - True si valide, false si pas valide
     */
    public function isValid()
    {
        return count($this->errors) === 0;
    }

    /**
     * @param string $key - name de l'input
     * @return bool - True si input à une erreur
     */
    public function hasError($key)
    {
        return (isset($this->errors[$key]));
    }

    /**
     * @param string $key - name de l'input
     * @return string - Erreur(s) de l'input
     */
    public function getError($key)
    {
        return ($this->hasError($key)) ? $this->errors[$key] : '';
    }

    /**
     * @return array - Array associatif des erreurs
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string - les erreurs à afficher au format HTML
     */
    public function getErrorsHtml()
    {
        $htmlRenderer = new HtmlRenderer($this);

        return $htmlRenderer->getErrors();
    }

    /**
     * @return string - les erreurs à afficher  au format Json
     */
    public function getErrorsJson()
    {
        $htmlRenderer = new JsonRenderer($this);

        return $htmlRenderer->getErrors();
    }
}