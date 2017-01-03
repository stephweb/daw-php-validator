# DAW PHP Validator

[![Latest Stable Version](https://poser.pugx.org/stephweb/daw-php-validator/v/stable)](https://packagist.org/packages/stephweb/daw-php-validator)
[![License](https://poser.pugx.org/stephweb/daw-php-validator/license)](https://packagist.org/packages/stephweb/daw-php-validator)

DAW PHP Validator is a PHP library of simple Validation system.

### Full documentation :
https://www.devandweb.fr/packages/daw-php-validator





## Installation
Installation via Composer :
```
php composer.phar require stephweb/daw-php-validator
```





## Example :
```php

<?php

// If you do not use Composer to download this package,
// you must do it "require" manually
require 'daw-php-validator/DawPhpValidator/bootstrap/autoload.php';

use DawPhpValidator\Validator;

if (isset($_POST) && !empty($_POST)) {
    $validator = new Validator();

    $validator = new Validator($_GET);  // pour y est à GET au lieu de POST

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