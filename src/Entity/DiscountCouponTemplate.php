<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class DiscountCouponTemplate
{

	public function __construct(
		public readonly string $guid,
		public readonly string $title,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			guid: $json['guid'],
			title: $json['title'],
		);
	}

}
