<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderPaymentMethod
{

	public function __construct(
		public readonly string $name,
		public readonly ?string $guid,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			name: $json['name'],
			guid: $json['guid'],
		);
	}

}
