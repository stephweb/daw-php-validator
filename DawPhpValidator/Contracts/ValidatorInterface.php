<?php

namespace DawPhpValidator\Contracts;

Interface ValidatorInterface
{
    /**
     * Validator constructor.
     *
     * @param null $requestHttp
     */
    public function __construct($requestHttp = null);
    
    /**
     * Eventuellement ajouter une règle da validation à ajouter
     *
     * @param string $rule
     * @param callable $callable
     * @param string $message
     * @throws ExceptionHandler
     */
    public static function extend($rule, callable $callable, $message);
    
    /**
     * Vérification des données soumises
     *
     * @param array $params
     */
    public function rules(array $params);

    /**
     * Pour éventuellemnt ajouter des traitements "à la volé" dans controllers
     *
     * @param string $error
     */
    public function addError($error);

    /**
     * @return bool - True si formulaire soumis est valide, false si pas valide
     */
    public function isValid();

    /**
     * @param string $key - name de l'input
     * @return bool - True si input à au minimum une erreur
     */
    public function hasError($key);

    /**
     * @param string $key - name de l'input
     * @return string - Erreur(s) de l'input
     */
    public function getError($key);

    /**
     * @return array - Array associatif des erreurs
     */
    public function getErrors();

    /**
     * @return string - les erreurs à afficher au format HTML
     */
    public function getErrorsHtml();

    /**
     * @return string - les erreurs à afficher au format Json
     */
    public function getErrorsJson();
}
