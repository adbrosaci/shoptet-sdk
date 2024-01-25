# Shoptet SDK
Simple Shoptet SDK.

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
