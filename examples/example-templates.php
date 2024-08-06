<?php declare(strict_types = 1);

use Adbros\Shoptet\Enum\SnippetLocation;
use Adbros\Shoptet\Request\TemplateSnippetRequest;
use Adbros\Shoptet\Sdk;

/** @var Sdk $sdk */
$sdk = require __DIR__ . '/config-sdk.php';

dump($sdk->setTemplateInclude([
	new TemplateSnippetRequest(
		location: SnippetLocation::CommonFooter,
		html: '<script>console.log("Hello, world!");</script>',
	),
]));

$sdk->deleteTemplateInclude(SnippetLocation::CommonHeader);
