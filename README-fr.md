# DAW PHP Validator

[![Latest Stable Version](https://poser.pugx.org/stephweb/daw-php-validator/v/stable)](https://packagist.org/packages/stephweb/daw-php-validator)
[![License](https://poser.pugx.org/stephweb/daw-php-validator/license)](https://packagist.org/packages/stephweb/daw-php-validator)

DAW PHP Validator est une library PHP d un simple système de Validation.


*Vérifiez facilement les données soumises.*
```php
<?php

if (Request::isPost()) {
    $validator = new Validator();

    $validator->rules($arrayRules);

    if ($validator->isValid()) {
        // Response with success
    }
}
```




### Pré-requis

* PHP >= 5.6.16




### Documentation complète

https://www.devandweb.fr/packages/daw-php-validator






## Installation

Installation via Composer :
```
php composer.phar require stephweb/daw-php-validator
```






## Sommaire

* Règles de validations disponibles
* Méthodes d'instance du Validator
* Comment faire ?
* Exemple
* Description de la méthode "rules"
* Pour éventuellement ajouter une règle de validation pour un traitement spécifique
* Pour éventuellement ajouter une erreur à la volé selon un traitement
* Vérifier si une erreur spécifique existe
* Modifier la configuration par défaut
* Contribuer






## Règles de validations disponibles

* 'alpha' => bool
* 'alpha_numeric' => bool
* 'between' => array (2 valeurs : valeur min, valeur max)
* 'confirm' => array (les 2 valeurs à vérifier)
* 'empty' => bool
* 'format_date' => bool
* 'format_date_time' => bool
* 'format_email' => bool
* 'format_ip' => bool
* 'format_name_file'
* 'format_postal_code' => bool
* 'format_slug' => bool
* 'format_tel' =>bool
* 'integer' => bool
* 'in_array' => array
* 'max' => int
* 'min' => int
* 'no_regex'=> string (regex qui ne doit pas matcher)
* 'regex'=> string (regex qui doit matcher)
* 'required' => bool






## Méthodes d'instance du Validator

* $validator = new Validator($optionalRequestMethod);
* $validator->extend(string $ruleName, callable $condition, string $errorMessage)
* $validator->rules($array)
* $validator->isValid() (return bool)
* $validator->getErrors() (return array)
* $validator->getErrorsHtml() (return string)
* $validator->getErrorsJson() (return string)
* $validator->hasError('input_name') (return bool)
* $validator->getError('input_name') (return string)






## Comment faire ?

* Il faut d'abord instancier le Validateur.
* Il faut ensuite lui passez lui des règles de validation.
* Il faut ensuite vérifiez si le formulaire soumis est valide en fonction des règles définis.
* On peut ensuite renvoyer la réponse au format HTML ou au format Json.






## Exemple

### Code PHP (avec pour exemple toute les règles de validations disponibles dans ma méthode "rules")

```php
<?php

// Si vous n'avez pas utiliser Composer pour télécharger ce package,
// vous devez faire le "require" manuellement
require 'daw-php-validator/DawPhpValidator/bootstrap/autoload.php';

use DawPhpValidator\Validator;

if (Request::isPost()) {
    // Instancier le Validateur
    $validator = new Validator();

    //$validator = new Validator($_GET);  // pour method GET au lieu de POST
    
    // Ajouter règle(s) de validation pour les inputs
    $validator->rules([
        'alpha' => [
             'alpha' => true
        ],
        'alpha_numeric' => [
            'label' => 'Alpha numerique',
            'alpha_numeric' => true
        ],
        'between' => [
            'between' => [2, 9]
        ],
        'password' => [
            'label' => 'Mot de passe',
            'confirm' => [$_POST['password'], $_POST['password_confirmation']]
        ],
        'empty' => [
            'empty' => true
        ],
        'date' => [
            'format_date' => true,
        ],
        'date_time' => [
            'format_date_time' => true,
        ],
        'email' => [
            'format_email' => true,
        ],
        'ip' => [
            'format_ip' => true,
        ],
        'name_file' => [
            'label' => 'Nom du fichier',
            'format_name_file' => true
        ],
        'postal_code' => [
            'format_postal_code' => true
        ],
        'slug' => [
            'format_slug' => true,     
        ],
        'tel' => [
            'format_tel' => true,     
        ],
        'integer' => [
            'integer' => true,     
        ],
        'in_array' => [
            'in_array' => [1, 2, 3],     
        ],
        'max' => [
            'max' => 10,     
        ],
        'min' => [
            'min' => 5,     
        ],
        'no_regex' => [
            'no_regex' => "#^[0-9]+$#",    
        ],
        'regex' => [
            'regex' => "#^[a-z]+$#",    
        ],
        'required' => [
            'label' => 'Requis',
            'required' => true,     
        ],
    ]);
    
    // Vérifier si le formulaire est valide
    if ($validator->isValid()) {
        // Succès
    } else {
        // Récupérer toutes les erreurs :
        var_dump($validator->getErrors());    // return array
        var_dump($validator->getErrorsHtml());    // return string
        var_dump($validator->getErrorsJson());    // return string
    }
}
```




### Code HTML (exemple de formulaire pour tester le code PHP de ci-dessus)

```html

<form action="#" method="post">
    <label>Alpha :</label>
    <input type="text" name="alpha"><br>

    <label>Alpha numerique :</label>
    <input type="text" name="alpha_numeric"><br>

    <label>Between :</label>
    <input type="text" name="between"><br>

    <label>Mot de passe :</label>
    <input type="password" name="password"><br>

    <label>Confirmamtion du Mot de passe :</label>
    <input type="password_confirmation" name="password_confirmation"><br>

    <label>Empty :</label>
    <input type="empty" name="empty"><br>

    <label>Date :</label>
    <input type="date" name="date"><br>

    <label>Date time :</label>
    <input type="date_time" name="date_time"><br>

    <label>Email :</label>
    <input type="email" name="email"><br>

    <label>IP :</label>
    <input type="ip" name="ip"><br>

    <label>Nom du fichier :</label>
    <input type="name_file" name="name_file"><br>

    <label>Code postale :</label>
    <input type="postal_code" name="postal_code"><br>

    <label>Slug :</label>
    <input type="text" name="slug"><br>

    <label>TEL :</label>
    <input type="text" name="tel"><br>

    <label>Integer :</label>
    <input type="text" name="integer"><br>

    <label>In array :</label>
    <select name="in_array">
        <option value="0">Choisir...</option>
        <option value="1">Choix 1</option>
        <option value="2">Choix 2</option>
        <option value="3">Choix 3</option>
    </select><br>

    <label>Max :</label>
    <input type="text" name="max"><br>

    <label>Min :</label>
    <input type="text" name="min"><br>

    <label>No regex :</label>
    <input type="text" name="no_regex"><br>

    <label>Regex :</label>
    <input type="text" name="regex"><br>

    <label>Requis :</label>
    <input type="text" name="required"><br>

    <input type="submit" value="Envoyer">
</form>
```






## Description de la méthode "rules"

En paramètre de la méthode "rules" on doit y passer un array associatif.
Les keys (string) doivent êtres les name des inputs, les values (array) doivent êtres les règles que l'on spécifie à cette input.
```php
<?php

use DawPhpValidator\Validator;

if (Request::isPost()) {
    $validator = new Validator();

    $validator->rules([
        'input_name_1' => $arrayRulesInput1,
        'input_name_2' => $arrayRulesInput2,
    ]);

    var_dump($validator->isValid());    // return bool
}
```






## Pour éventuellement ajouter une règle de validation pour un traitement spécifique

```php
<?php

use DawPhpValidator\Validator;

if (Request::isPost()) {
    $validator = new Validator();
    
    // Ajouter une nouvelle règle de validation
    // $input sera le name de l'input
    // $value sera la valeur soumise de l'input
    // $parameters sera sa valeur spécifiée à la règle de validation au 'rule_name' à un 'name_input' dans la method "rules"
    $validator->extend('rule_name', function ($input, $value, $parameters) {
        return $value == $parameters;    // Retournez votre condition pour retourner un booléen
    }, 'Votre message d erreur personnalisé.');
    
    // Ajouter règle(s) de validation pour les inputs
    $validator->rules([
        // Ajouter la règle de validation que vous venez de créer pour le input
        'input_name' => ['rule_name'=>'value_to_rules'],
    ]);
}
```






## Pour éventuellement ajouter une erreur à la volé selon un traitement

```php
<?php

if ($condition === false) {
     $validator->addError('Votre message d erreur personnalisé...');
}
```






## Vérifier si une erreur spécifique existe

```php
<?php

if ($validator->hasError('input_name')) {
    var_dump($validator->getError('input_name'));    // return string
}
```






## Modifier la configuration par défaut

```php
<?php

use DawPhpValidator\Config\Config;

// Changer la langue. Est à 'fr' par défaut. 'fr' et 'en' sont supportés
Config::set(['lang'=>'en']);
```






## Contribuer

### Bugs et vulnérabilités de sécurité

Si vous découvrez un bug ou une faille de sécurité au sein de DAW PHP Validator, merci d'envoyez message à Steph.
Toutes les bugs et failles de sécurité seront traitées rapidement.




### Licence

DAW PHP Validator est une librarie Open Source sous la licence MIT.