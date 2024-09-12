# Package to interact database query using AI

[![Latest Version on Packagist](https://img.shields.io/packagist/v/triptasoft/filament-ai-sql.svg?style=flat-square)](https://packagist.org/packages/triptasoft/filament-ai-sql)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/triptasoft/filament-ai-sql/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/triptasoft/filament-ai-sql/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/triptasoft/filament-ai-sql/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/triptasoft/filament-ai-sql/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/triptasoft/filament-ai-sql.svg?style=flat-square)](https://packagist.org/packages/triptasoft/filament-ai-sql)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require triptasoft/filament-ai-sql
```

Add GEMINI_API_KEY in your .env:
Get your API here https://aistudio.google.com/

```bash
GEMINI_API_KEY=your_gemini_api_key
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-ai-sql-config"
```

## Usage

In Filament Panel Provider add this widget

```php
->widgets([
    \Triptasoft\FilamentAiSql\FilamentAiSql::class
])
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [triptasoft](https://github.com/triptasoft)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
