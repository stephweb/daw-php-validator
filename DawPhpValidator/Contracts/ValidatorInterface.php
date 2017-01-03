<?php

namespace DawPhpValidator\Contracts;

Interface ValidatorInterface
{
    /**
     * Validator constructor.
     *
     * @param null $requestHttp
     */
    public function __construct($requestHttp=null);
    
    /**
     * Vérification des données envoyées en POST
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
     * @return bool - True si valide, false si pas valide
     */
    public function isValid();

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