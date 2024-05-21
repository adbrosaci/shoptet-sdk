<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class EshopInfo
{

	/**
	 * @param array<EshopInfoCurrency> $currencies
	 * @param array<EshopInfoUrl> $urls
	 */
	public function __construct(
		public readonly array $currencies,
		public readonly array $urls,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			currencies: array_map(fn (array $item): EshopInfoCurrency => EshopInfoCurrency::fromJson($item), $json['currencies']),
			urls: array_map(fn (array $item): EshopInfoUrl => EshopInfoUrl::fromJson($item), $json['urls']),
		);
	}

}
