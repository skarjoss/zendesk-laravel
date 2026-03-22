# Laravel Zendesk

This package provides integration with the Zendesk API. It supports creating tickets, retrieving and updating tickets, deleting tickets, etc.

The package simply provides a `Zendesk` facade that acts as a wrapper to the [zendesk/zendesk_api_client_php](https://github.com/zendesk/zendesk_api_client_php) package.

## Compatibility

- PHP 8.1+
- Laravel 10, 11 and 12

**NB:** Currently only supports token-based authentication.

## Installation

You can install this package via Composer using:

```bash
composer require huddledigital/zendesk-laravel
```

Laravel uses package auto-discovery, so you do not need to register the service provider manually.

If you want to register the package explicitly, add the provider below:

```php
// config/app.php
'providers' => [
    ...
    Huddle\Zendesk\Providers\ZendeskServiceProvider::class,
    ...
];
```

If you want to make use of the facade you must install it as well.

Laravel auto-discovers the service provider, but facades still need an alias if you want to use the short `Zendesk` class name in older applications.

```php
// config/app.php
'aliases' => [
    ..
    'Zendesk' => Huddle\Zendesk\Facades\Zendesk::class,
];
```

## Configuration

To publish the config file to `config/zendesk-laravel.php` run:

```bash
php artisan vendor:publish --provider="Huddle\Zendesk\Providers\ZendeskServiceProvider"
```


Set your configuration using **environment variables**, either in your `.env` file or on your server's control panel:

```dotenv
ZENDESK_DRIVER=api
ZENDESK_SUBDOMAIN=
ZENDESK_USERNAME=
ZENDESK_TOKEN=
```

- `ZENDESK_SUBDOMAIN`

The subdomain part of your Zendesk organisation URL.

e.g. http://huddledigital.zendesk.com use **huddledigital**

- `ZENDESK_USERNAME`

The username for the authenticating account.

- `ZENDESK_TOKEN`

The API access token. You can create one at: `https://SUBDOMAIN.zendesk.com/agent/admin/api/settings`

- `ZENDESK_DRIVER` _(Optional)_

Set this to `null` or `log` to prevent calling the Zendesk API directly from your environment.

## Usage

### Facade

The `Zendesk` facade acts as a wrapper for an instance of the `Zendesk\API\Client` class. Any methods available on this class ([documentation here](https://github.com/zendesk/zendesk_api_client_php#usage)) are available through the facade. for example:

```php
// Get all tickets
Zendesk::tickets()->findAll();

// Create a new ticket
Zendesk::tickets()->create([
  'subject' => 'Subject',
  'comment' => [
      'body' => 'Ticket content.'
  ],
  'priority' => 'normal'
]);

// Update multiple tickets
Zendesk::ticket([123, 456])->update([
  'status' => 'urgent'
]);

// Delete a ticket
Zendesk::ticket(123)->delete();
```

### Dependency injection

If you'd prefer not to use the facade, you can skip adding the alias to `config/app.php` and instead resolve the `zendesk` binding from the container. You can then use all of the same methods on this object as you would on the facade.

```php
$zendesk = app('zendesk');

$zendesk->tickets()->create([
    'subject' => 'Subject',
    'comment' => [
        'body' => 'Ticket content.',
    ],
    'priority' => 'normal',
]);
```

This package is available under the [MIT license](http://opensource.org/licenses/MIT).
