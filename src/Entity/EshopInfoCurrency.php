<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\Currency;

class EshopInfoCurrency
{

	public function __construct(
		public readonly Currency $code,
		public readonly string $title,
		public readonly bool $isDefault,
		public readonly bool $isDefaultAdmin,
		public readonly bool $isDefaultDocuments,
		public readonly bool $isVisible,
		public readonly float $exchangeRate,
		public readonly int $priority,
		public readonly EshopInfoCurrencyDisplay $display,
		public readonly int $priceDecimalPlaces,
		public readonly float $minimalOrderValue,
		public readonly EshopInfoBankAccount $bankAccount,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			code: Currency::from($json['code']),
			title: $json['title'],
			isDefault: $json['isDefault'],
			isDefaultAdmin: $json['isDefaultAdmin'],
			isDefaultDocuments: $json['isDefaultDocuments'],
			isVisible: $json['isVisible'],
			exchangeRate: floatval($json['exchangeRate']),
			priority: $json['priority'],
			display: EshopInfoCurrencyDisplay::fromJson($json['display']),
			priceDecimalPlaces: $json['priceDecimalPlaces'],
			minimalOrderValue: floatval($json['minimalOrderValue']),
			bankAccount: EshopInfoBankAccount::fromJson($json['bankAccount']),
		);
	}

}
