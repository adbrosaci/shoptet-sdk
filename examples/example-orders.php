<?php declare(strict_types = 1);

use Adbros\Shoptet\Sdk;

/** @var Sdk $sdk */
$sdk = require __DIR__ . '/config-sdk.php';

dump($sdk->getOrders());
