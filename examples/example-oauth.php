<?php declare(strict_types = 1);

use Adbros\Shoptet\OAuth;

require __DIR__ . '/config.php';

$oAuth = new OAuth(
	clientId: getenv('CLIENT_ID'),
	clientSecret: getenv('CLIENT_SECRET'),
	eshopUrl: getenv('ESHOP_URL'),
);

dump($oAuth->getApiAccessToken(getenv('OAUTH_ACCESS_TOKEN')));
