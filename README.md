# Shoptet SDK

[![main workflow](https://github.com/adbrosaci/shoptet-sdk/actions/workflows/main.yml/badge.svg)](https://github.com/adbrosaci/shoptet-sdk/actions/workflows/main.yml)
[![Licence](https://img.shields.io/packagist/l/adbros/shoptet-sdk.svg?style=flat-square)](https://packagist.org/packages/adbros/shoptet-sdk)
[![Downloads this Month](https://img.shields.io/packagist/dm/adbros/shoptet-sdk.svg?style=flat-square)](https://packagist.org/packages/adbros/shoptet-sdk)
[![Downloads total](https://img.shields.io/packagist/dt/adbros/shoptet-sdk.svg?style=flat-square)](https://packagist.org/packages/adbros/shoptet-sdk)
[![Latest stable](https://img.shields.io/packagist/v/adbros/shoptet-sdk.svg?style=flat-square)](https://packagist.org/packages/adbros/shoptet-sdk)


## Installation
```shell
composer require adbros/shoptet-sdk
```

## Usage

```php
<?php declare(strict_types = 1);

use Adbros\Shoptet\OAuth;
use Adbros\Shoptet\Sdk;

// Initialize OAuth
$oAuth = new OAuth(
	clientId: getenv('CLIENT_ID'),
	clientSecret: getenv('CLIENT_SECRET'),
	eshopUrl: getenv('ESHOP_URL'),
);

// Get oAuthAccessToken in installation process
$oAuthAccessToken = $oAuth->getOAuthAccessToken(
	code: $_GET['code'],
	redirectUri: 'https://example.com/install',
);

// Get apiAccessToken before API call
$apiAccessToken = $oAuth->getApiAccessToken(
	oAuthAccessToken: $oAuthAccessToken->accessToken,
);

// Initialize SDK
$sdk = new Sdk(
	apiAccessToken: $apiAccessToken->accessToken,
);

// Get customers
$page = 1;

do {
	$customers = $sdk->getCustomers($page);
	
	foreach ($customers->customers as $customer) {
		// Get customer
		$customerDetail = $sdk->getCustomer($customer->guid);
	}
} while ($page++ < $customers->paginator->pageCount);
```
