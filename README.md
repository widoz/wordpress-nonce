[![Build Status](https://travis-ci.org/widoz/unprefix-nonce.svg?branch=dev)](https://travis-ci.org/widoz/unprefix-nonce)
[![codecov](https://codecov.io/gh/widoz/unprefix-nonce/branch/dev/graph/badge.svg)](https://codecov.io/gh/widoz/unprefix-nonce)


# Unprefix Nonce

A WordPress package that wrap the nonce logic in a OOP way.

# Requirements

- PHP 5.6+
- WordPress 4.8+
- [Slugify ^3.0](https://github.com/cocur/slugify)
- [Unprefix Template Loader ^3.0](https://github.com/widoz/template-loader)

# Installation

Use [composer](https://getcomposer.org/) 

`composer require unprefix/nonce`

# License

The package is open source and released under GPL-2 license.
See LICENSE for more info.

# Issues

You can submit issues via [github issues](https://github.com/widoz/unprefix-nonce/issues).

# Documentation

## Create a basic Nonce

```php
use Unprefix\Nonce\Nonce;

// This create a new nonce instance.
$nonce = new Nonce('action_name');

// To retrieve the nonce just do this.
$nonce->nonce();

// To retrieve the nonce action.
$nonce->action();
```

### Create a basic Nonce with helper

```php
use Unprefix\Nonce\Nonce;

// This will generate the nonce and return the nonce string, all at once.
$nonce = Nonce::create('nonce_action');
```

## Create a URL Nonce

The constructor for `NonceUrl` take three parameters, a `Nonce` instance, a nonce **name** and an **url** in which add the nonce.

```php
use Unprefix\Nonce\NonceUrl;

$nonceUrl = new NonceUrl(
    new Nonce('nonce_action'),
    'nonce_name',
    'http://www.mycustomurl.com'
);

// Retrieve the url.
$nonceUrl->url();

// To retrieve the name.
$nonceUrl->name();
```

### Create a nonce url with helper

You don't need to pass an `Nonce` instance when using the helper function, just pass the action name as first 
parameter.

```php
use Unprefix\Nonce\NonceUrl;

// Retrieve the nonce url string at once.
$nonceUrl = NonceUrl::create('action_name', 'nonce_name', 'http://www.mycustomurl.com');
```

## Create a nonce Field

Like `NonceUrl` to create a `NonceField` you must pass a `Nonce` instance along with the **name** and the **referrer** parameter.

The referrer parameter is optional, you can ignore it if you don't want to include the referrer input field.

```php
use Unprefix\Nonce\NonceField;

$nonceField = new NonceField(
    new Nonce('nonce_action'),
    'nonce_name',
    true
);

// Show the nonce field.
$nonceField->tmpl(
    $nonceField->data()
);
```

The `NonceField` class implements Unprefix\TemplateInterface from [unprefix/unprefix-templateloader](https://github.com/widoz/template-loader) to print the markup of the field.

The file is searched within the `views` directory two level up of the `src/` directory.

It is possible to filter the template path by hooking into `tmploader_template_file_path` filter as you can see in [Loader.php](https://github.com/widoz/template-loader/blob/master/src/Loader.php#L256)

Also, like other classes you can use an helper function to print the field at once.

```php
use Unprefix\Nonce\NonceField;

NonceField::field('nonce_action', 'nonce_name', true);
```

## Verify Nonce

To verify a nonce it is possible to use the `NonceVerification` class.

The class provide a single method with which is possible to verify nonces, admin referrer and ajax referrer.

```php
use Unprefix\Nonce\NonceValidation;

// Create the instance
$nonceVerify = new NonceVerification(
    new Nonce('nonce_action'),
    'name_action',
    'POST', // But can be GET, REQUEST
    false
);

$nonceVerify->verify();
```