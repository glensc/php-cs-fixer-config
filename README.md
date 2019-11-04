# php-cs-fixer-config

Provides default configuration and configuration builder for [friendsofphp/php-cs-fixer].

[friendsofphp/php-cs-fixer]: http://github.com/FriendsOfPHP/PHP-CS-Fixer

## Installation

Run

```sh
$ composer require --dev glen/php-cs-fixer-config
```

## Usage

### Configuration

Create a configuration file `.php_cs` in the root of your project:

```php
<?php
// vim:ft=php

/** @var \glen\PhpCsFixerConfig\Config $config */
$config = require __DIR__ . '/vendor/glen/php-cs-fixer-config/phpcs.php';

$rules = $config->getRuleBuilder();
$rules['indentation_type'] = false;
$rules['class_definition'] = false;

return $config;
```

## License

This package is licensed using the MIT License.

## Credits

This project README is inspired by [localheinz/php-cs-fixer-config].

[localheinz/php-cs-fixer-config]: https://github.com/localheinz/php-cs-fixer-config
