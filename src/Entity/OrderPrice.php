<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\Currency;

class OrderPrice
{

	public function __construct(
		public readonly string $vat,
		public readonly string $toPay,
		public readonly Currency $currencyCode,
		public readonly string $withVat,
		public readonly string $withoutVat,
		public readonly string $exchangeRate,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			vat: $json['vat'],
			toPay: $json['toPay'],
			currencyCode: Currency::from($json['currencyCode']),
			withVat: $json['withVat'],
			withoutVat: $json['withoutVat'],
			exchangeRate: $json['exchangeRate'],
		);
	}

}
