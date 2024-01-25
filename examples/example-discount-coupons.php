<?php declare(strict_types = 1);

use Adbros\Shoptet\Enum\Currency;
use Adbros\Shoptet\Enum\DiscountType;
use Adbros\Shoptet\Request\DiscountCouponRequest;
use Adbros\Shoptet\Sdk;
use Nette\Utils\Random;

/** @var Sdk $sdk */
$sdk = require __DIR__ . '/config-sdk.php';

$templates = $sdk->getDiscountCouponTemplates();

if ($templates !== []) {
	$coupons = $sdk->createDiscountCoupons([
		new DiscountCouponRequest(
			code: Random::generate(),
			discountType: DiscountType::fixed,
			template: $templates[0]->guid,
			amount: 100,
			currency: Currency::czk,
		),
	]);

	dump($coupons);
}
