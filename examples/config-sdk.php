<?php declare(strict_types = 1);

use Adbros\Shoptet\Sdk;

require __DIR__ . '/config.php';

return new Sdk(
	apiAccessToken: getenv('API_ACCESS_TOKEN'),
);
