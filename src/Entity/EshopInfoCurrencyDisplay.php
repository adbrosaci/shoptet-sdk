<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class EshopInfoCurrencyDisplay
{

	public function __construct(
		public readonly string $text,
		public readonly string $location,
		public readonly string $decimalsSeparator,
		public readonly string $thousandsSeparator,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			text: $json['text'],
			location: $json['location'],
			decimalsSeparator: $json['decimalsSeparator'],
			thousandsSeparator: $json['thousandsSeparator'],
		);
	}

}
