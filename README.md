# DAW PHP Validator - Library - Form validation

[![Latest Stable Version](https://poser.pugx.org/stephweb/daw-php-validator/v/stable)](https://packagist.org/packages/stephweb/daw-php-validator)
[![License](https://poser.pugx.org/stephweb/daw-php-validator/license)](https://packagist.org/packages/stephweb/daw-php-validator)

DAW PHP Validator is a Open Source PHP library of simple validation system.

*Verify easily the submitted data!*

Simple validation:
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

Add custom validation rules:
```php
<?php

Validator::extend('rule_name', function ($input, $value, $parameters) {
    return $value == $parameters;
}, 'Your custom error message.');
```

You also have many other features



### Requirements

* PHP >= 7.0




### Documentation

* The documentation is in folder "docs" of this package:

[Documentation](https://github.com/stephweb/daw-php-validator/blob/master/docs/doc.md)

* The documentation is also on the package website:

[DAW PHP Validator - English documentation](https://www.devandweb.com/packages/daw-php-validator)
|
[DAW PHP Validator - French documentation](https://www.devandweb.fr/packages/daw-php-validator)




## Installation

Installation via Composer:
```
php composer.phar require stephweb/daw-php-validator 1.1.*
```






## Contributing

### Bugs and security Vulnerabilities

If you discover a bug or a security vulnerability within DAW PHP Validator, please send a message to Steph. Thank you.
All bugs and all security vulnerabilities will be promptly addressed.




### License

The DAW PHP Validator is Open Source software licensed under the MIT license.




### Author

Package developed by:
[Développeur PHP de Grenoble](https://www.devandweb.fr)