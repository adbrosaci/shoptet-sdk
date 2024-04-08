<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderPrice
{

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
		);
	}

}
