
<p align="center">
  <img src="logo.png">
</p>

<p align="center">
<a href="https://github.com/grayloon/magento-laravel-api/actions"><img src="https://github.com/grayloon/magento-laravel-api/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/grayloon/laravel-magento-api"><img src="https://img.shields.io/packagist/v/grayloon/laravel-magento-api.svg?style=flat" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/grayloon/laravel-magento-api"><img src="https://github.styleci.io/repos/277585119/shield?branch=master" alt="Style CI"></a>
<a href="https://packagist.org/packages/grayloon/magento-laravel-api"><img src="https://img.shields.io/packagist/dt/grayloon/laravel-magento-api?style=flat" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/grayloon/laravel-magento-api"><img src="https://img.shields.io/badge/License-MIT-brightgreen.svg" alt="License"></a>
</p>

# Laravel - Magento API

A Magento 2 API Object Oriented wrapper for a Laravel application. Also includes an optional opinionated storage system for 
consuming Magento 2 data in your Laravel application.

## Installation

You can install the package via composer:

```bash q
composer require grayloon/laravel-magento-api
```

Publish the config options:
```bash
php artisan vendor:publish --provider="Grayloon\Magento\MagentoServiceProvider" --tag="config"
```

Optional:
If you are wanting to store the data from the Magento API and want to use our opinionated storage system, publish the migrations:
```bash
php artisan vendor:publish --provider="Grayloon\Magento\MagentoServiceProvider" --tag="migrations"
```

Configure your Magento 2 API endpoint and token in your `.env` file:
```
MAGENTO_BASE_URL="https://mydomain.com"
MAGENTO_ACCESS_TOKEN="client_access_token_here"
```

## API Usage

Example:
```php
use Grayloon\Magento\Magento;

$magento = new Magento();
$response = $magento->api('products')->all();

$response->body() : string;
$response->json() : array|mixed;
$response->status() : int;
$response->ok() : bool;
$response->successful() : bool;
$response->failed() : bool;
$response->serverError() : bool;
$response->clientError() : bool;
```

### Available Methods:

#### Categories

Get a list of all categories:
```php
$magento->api('categories')->all($pageSize = 50, $currentPage = 1);
```

Get a count of all categories:
```php
$magento->api('categories')->count(); 
```

#### Customers

Get a list of customers:
```php
$magento->api('customers')->all($pageSize = 50, $currentPage = 1);
```

#### Integration (Tokens)

Generate a customer token:
```php
$magento->api('integration')->customerToken($username, $password);
```

Generate an admin token:
```php
$magento->api('integration')->adminToken($username, $password);
```

#### Products
Get a list of products:
```php
$magento->api('products')->all($pageSize = 50, $currentPage = 1); 
```

Get a count of all products:
```php
$magento->api('products')->count(); 
```

Get info about a product by the product SKU:
```php
$magento->api('products')->show($sku);
```

#### Schema
Get a schema blueprint of the Magento 2 REST API:
```php
$magento->api('schema')->show(); 
```

## Jobs

> In order use these queue jobs, you must have registered the migrations from the installation section noted above.

This package has many pre-built queue jobs to sync your Magento products to your Laravel application. Feel free to leverage these jobs or create your own.

Updates all products from the Magento API:
```php
Bus::dispatch(\Grayloon\Magento\Jobs\SyncMagentoProducts::class);
```

Updates a specified product from the Magento API:
```php
Bus::dispatch(\Grayloon\Magento\Jobs\SyncMagentoProduct::class, $sku);
```

Updates all categories from the Magento API:
```php
Bus::dispatch(\Grayloon\Magento\Jobs\SyncMagentoCategories::class);
```


## API / Webhooks

> In order use these api routes, you must have registered the migrations from the installation section noted above.

This package has included routes to automatically update Magento information from the API. These can be utilized with Magento Webhooks to keep your items in sync.

> All routes are guarded by the default `API` Laravel middleware.

Fire the `SyncMagentoProduct($sku)` job to update a specified product SKU:
```
/api/laravel-magento-api/products/update/{sku}
```


## Commands

> In order use these commands, you must have registered the migrations from the installation section noted above.

Launch a job to import all categories from the Magento 2 REST API:
```bash
php artisan magento:sync-categories
```

Launch a job to import all customers from the Magento 2 REST API:
```bash
php artisan magento:sync-customers
```

Launch a job to import all products from the Magento 2 REST API:
```bash
php artisan magento:sync-products
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email webmaster@grayloon.com instead of using the issue tracker.

## Credits

- [Gray Loon Marketing Group](https://github.com/grayloon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.