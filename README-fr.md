# DAW PHP Validator

[![Latest Stable Version](https://poser.pugx.org/stephweb/daw-php-validator/v/stable)](https://packagist.org/packages/stephweb/daw-php-validator)
[![License](https://poser.pugx.org/stephweb/daw-php-validator/license)](https://packagist.org/packages/stephweb/daw-php-validator)

DAW PHP Validator est une library PHP d un simple système de Validation.

### Documentation complète :
https://www.devandweb.fr/packages/daw-php-validator





## Installation
Installation via Composer :
```
php composer.phar require stephweb/daw-php-validator
```





## Exemple :

### Code PHP :
```php

<?php

// If you do not use Composer to download this package,
// you must do it "require" manually
require 'daw-php-validator/DawPhpValidator/bootstrap/autoload.php';

use DawPhpValidator\Validator;

if (isset($_POST) && !empty($_POST)) {
    $validator = new Validator();

    //$validator = new Validator($_GET);  // pour method GET au lieu de POST

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
            'no_regex'=>"#^[0-9]+$#",    
        ],
        'regex' => [
            'regex'=>"#^[a-z]+$#",    
        ],
        'required' => [
            'label' => 'Requis',
            'required' => true,     
        ],
    ]);

    if ($validator->isValid()) {
        // Success
    } else {
        var_dump($validator->getErrors());
        var_dump($validator->getErrorsHtml());
        var_dump($validator->getErrorsJson());
    }
}


```



### Code HTML :
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