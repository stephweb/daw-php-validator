<?php

namespace DawPhpValidator;

use DawPhpValidator\Contracts\ValidatorInterface;
use DawPhpValidator\Config\Lang;
use DawPhpValidator\Exception\ExceptionHandler;
use DawPhpValidator\Support\Facades\Request;
use DawPhpValidator\Support\String\Str;

/**
 * Pour vérifications des données
 */
class Validator implements ValidatorInterface
{
    /**
     * Eventuel(s) règle(s) da validation à ajouter
     *
     * @var array
     */
    private static $extends = [];

    /**
     * Langue choisie dans config/config.php
     *
     * @var string
     */
    private static $langValidation;
    
    /**
     * Pour éventuellement personnaliser certains attributs de validation
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
     * POST ou GET - Sera à POST par defaut
     *
     * @var mixed
     */
    private $requestMethod;

    /**
     * Attributs de validation personnalisés
     *
     * @var array
     */
    private $attributes;

    /**
     * Contiendra les éventuels erreurs
     *
     * @var array
     */
    private $errors = [];

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
     * @param null $requestMethod
     */
    public function __construct($requestMethod = null)
    {
        $this->requestMethod = ($requestMethod != null) ? $requestMethod : Request::getPost()->all();

        self::$langValidation = Lang::getInstance()->validation();

        $this->attributes = self::$langValidation['attributes'];
    }

    /**
     * Eventuellement ajouter une règle da validation à ajouter
     *
     * @param string $rule
     * @param callable $callable
     * @param string $message
     * @throws ExceptionHandler
     */
    public static function extend(string $rule, callable $callable, string $message)
    {
        if (array_key_exists($rule, self::$langValidation)) {
            throw new ExceptionHandler('Rule "'.$rule.'" already exists.');
        }

        self::$extends[$rule]['bool'] = $callable;
        self::$extends[$rule]['message'] = $message;
    }
    
    /**
     * Vérification des données soumises
     *
     * @param array $array
     * @throws ExceptionHandler
     */
    public function rules(array $array)
    {
        foreach ($array as $input => $rules) {
            $this->input = $input;

            if (is_array($rules)) {
                $this->setLabel($rules);
                
                foreach ($rules as $rule => $value) {
                    if ($rule != 'label') {
                        if ($rule == 'required' OR isset($this->requestMethod[$this->input])) {
                            $this->value = $value;

                            $this->callRule($rule);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param array $rules
     */
    private function setLabel(array $rules)
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
     * Appeler la règle de validation
     *
     * @param string $rule
     * @throws ExceptionHandler
     */
    protected function callRule(string $rule)
    {
        $methodVerify = 'verify'.Str::convertSnakeCaseToCamelCase($rule);

        if (method_exists($this, $methodVerify)) {
            $this->$methodVerify();
        } else {
            if (!array_key_exists($rule, self::$extends)) {
                throw new ExceptionHandler('Rule "'.$rule.'" not exist.');
            }

            $this->ruleWithExtend($rule);
        }
    }

    /**
     * @param string $rule
     */
    private function ruleWithExtend(string $rule)
    {
        if (self::$extends[$rule]['bool']($this->input, $this->requestMethod[$this->input], $this->value) === false) {
            $this->errors[$this->input] = $this->label.': '.self::$extends[$rule]['message'];
        }
    }

    /**
     * Vérifier que valeur entrée dans le champ est bien alphabétique
     */
    private function verifyAlpha()
    {
        if ($this->value === true && !preg_match(self::REGEX_ALPHA, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('alpha');
        }
    }

    /**
     * Vérifier que valeur entrée dans le champ est bien alphanumérique
     */
    private function verifyAlphaNumeric()
    {
        if ($this->value === true && !preg_match(self::REGEX_ALPHA_NUMERIC, $this->requestMethod[$this->input])) {
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
        if ($this->requestMethod[$this->input] < $this->value[0] OR $this->requestMethod[$this->input] > $this->value[1]) {
            $this->errors[$this->input] = $this->pushError('between', $this->value);
        }
    }

    /**
     * Pour obliger 2 valeurs à êtres égales
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
        if ($this->requestMethod[$this->input] != '') {
            $this->errors[$this->input] = $this->pushError('empty');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'une date
     */
    private function verifyFormatDate()
    {
        if ($this->value === true && !preg_match(self::REGEX_DATE, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_date');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'une date/heure
     */
    private function verifyFormatDateTime()
    {
        if ($this->value === true && !preg_match(self::REGEX_DATE_TIME, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_date_time');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'un Email
     */
    private function verifyFormatEmail()
    {
        if ($this->value === true && !filter_var($this->requestMethod[$this->input], FILTER_VALIDATE_EMAIL) == true) {
            $this->errors[$this->input] = $this->pushError('format_email');
        }
    }

    /**
     * Verifier que valeur entrée est bien au format d'une adresse IP
     */
    private function verifyFormatIp()
    {
        if ($this->value === true && !filter_var($this->requestMethod[$this->input], FILTER_VALIDATE_IP)) {
            $this->errors[$this->input] = $this->pushError('format_ip');
        }   
    }

    /**
     * Verifier que valeur entrée est bien au format d'un nom de fichier
     */
    private function verifyFormatNameFile()
    {
        if ($this->value === true && preg_match(self::REGEX_CHARACTERS_PROHIBITED_NAME_FILE, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_name_file');
        }
    }

    /**
     * Verifier que valeur entrée est bien au format d'un code postale
     */
    private function verifyFormatPostalCode()
    {
        if ($this->value === true && !preg_match(self::REGEX_POSTALE_CODE, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_postal_code');
        }
    }
    
    /**
     * Vérifier que valeur entrée est bien au format d'un d'un slug
     */
    private function verifyFormatSlug()
    {
        if ($this->value === true && !preg_match(self::REGEX_SLUG, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_slug');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'un d'une URL
     */
    private function verifyFormatUrl()
    {
        if ($this->value === true && !filter_var($this->requestMethod[$this->input], FILTER_VALIDATE_URL)) {
            $this->errors[$this->input] = $this->pushError('format_url');
        }
    }

    /**
     * Vérifier que valeur entrée est bien au format d'un numéro de téléphone
     */
    private function verifyFormatTel()
    {
        if ($this->value === true && !preg_match(self::REGEX_TEL, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('format_tel');
        }
    }

    /**
     * Vérifier que valeur entrée dans le champ est bien un entier
     */
    private function verifyInteger()
    {
        if ($this->value === true && !preg_match(self::REGEX_INTEGER, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('integer');
        }
    }

    /**
     * Vérifier si donnée envoyés est dans un array
     */
    private function verifyInArray()
    {
        if (!in_array($this->requestMethod[$this->input], $this->value)) {
            $this->errors[$this->input] = $this->pushError('in_array');
        }
    }

    /**
     * Nombre de caractères maximum autorisés dans champ
     */
    private function verifyMax()
    {
        if (mb_strlen($this->requestMethod[$this->input]) > $this->value) {
            $this->errors[$this->input] = $this->pushError('max', $this->value);
        }
    }

    /**
     * Nombre de caractères minimum autorisés dans champ
     */
    private function verifyMin()
    {
        if (mb_strlen($this->requestMethod[$this->input]) < $this->value) {
            $this->errors[$this->input] = $this->pushError('min', $this->value);
        }
    }

    /**
     * Verifier que valeur entrée n'est pas au format d'un regex spécifique
     */
    private function verifyNoRegex()
    {
        if (preg_match($this->value, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('no_regex', $this->value);
        }
    }
    
    /**
     * Verifier que valeur entrée est bien au format d'un regex spécifique
     */
    private function verifyRegex()
    {
        if (!preg_match($this->value, $this->requestMethod[$this->input])) {
            $this->errors[$this->input] = $this->pushError('regex', $this->value);
        }
    }

    /**
     * Champ doit obligatoirement etre remplis
     */
    private function verifyRequired()
    {
        if (
            ($this->value === true && !array_key_exists($this->input, $this->requestMethod)) OR
            $this->requestMethod[$this->input] == '')
        {
            $this->errors[$this->input] = $this->pushError('required');
        }
    }

    /**
     * Si il y a une erreur -> pushera une erreur par input
     *
     * @param string $key - Key dans tableaux inclut dans resources/lang...
     * @param null|string $value - Pour éventuellemnt {value} dans tableaux inclut dans resources/lang...
     * @return string
     */
    private function pushError(string $key, $value = null): string
    {
        $errorMessage = str_replace('{field}', $this->label, self::$langValidation[$key]);

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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $input
     * @param string $error
     */
    public function addErrorWithInput(string $input, string $error)
    {
        $this->errors[$input] = $error;
    }

    /**
     * Pour éventuellemnt ajouter des erreurs "à la volé" selon éventuels traitements
     *
     * @param string $error
     */
    public function addError(string $error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return bool - True si formulaire soumis est valide, false si pas valide
     */
    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }

    /**
     * @param string $key - name de l'input
     * @return bool - True si input à au minimum une erreur
     */
    public function hasError(string $key): bool
    {
        return (isset($this->errors[$key]));
    }

    /**
     * @param string $key - name de l'input
     * @return string - Erreur(s) de l'input
     */
    public function getError(string $key): string
    {
        return ($this->hasError($key)) ? $this->errors[$key] : '';
    }

    /**
     * @return array - Array associatif des erreurs
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string - les erreurs à afficher au format HTML
     */
    public function getErrorsHtml(): string
    {
        $htmlRenderer = new HtmlRenderer($this);

        return $htmlRenderer->getErrors();
    }

    /**
     * @return string - les erreurs à afficher  au format Json
     */
    public function getErrorsJson(): string
    {
        $jsonRenderer = new JsonRenderer($this);

        return $jsonRenderer->getErrors();
    }
}
