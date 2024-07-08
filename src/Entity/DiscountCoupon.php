<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\Currency;
use Adbros\Shoptet\Enum\DiscountType;
use Adbros\Shoptet\Enum\ShippingPrice;
use DateTimeImmutable;

class DiscountCoupon
{

	public function __construct(
		public readonly string $code,
		public readonly DiscountType $discountType,
		public readonly string $template,
		public readonly ?float $amount,
		public readonly ?float $ratio,
		public readonly ?float $minPrice,
		public readonly ?Currency $currency,
		public readonly ShippingPrice $shippingPrice,
		public readonly ?DateTimeImmutable $validFrom,
		public readonly ?DateTimeImmutable $validTo,
		public readonly bool $reusable,
		public readonly ?string $remark,
		public readonly int $usedCount,
		public readonly DateTimeImmutable $creationTime,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			code: $json['code'],
			discountType: DiscountType::from($json['discountType']),
			template: $json['template'],
			amount: $json['amount'] !== null
				? floatval($json['amount'])
				: null,
			ratio: $json['ratio'] !== null
				? floatval($json['ratio'])
				: null,
			minPrice: $json['minPrice'] !== null
				? floatval($json['minPrice'])
				: null,
			currency: $json['currency'] !== null
				? Currency::from($json['currency'])
				: null,
			shippingPrice: ShippingPrice::from($json['shippingPrice']),
			validFrom: $json['validFrom'] !== null
				? new DateTimeImmutable($json['validFrom'])
				: null,
			validTo: $json['validTo'] !== null
				? new DateTimeImmutable($json['validTo'])
				: null,
			reusable: $json['reusable'],
			remark: $json['remark'],
			usedCount: $json['usedCount'],
			creationTime: new DateTimeImmutable($json['creationTime']),
		);
	}

}
