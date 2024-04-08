<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderStatus
{

	public function __construct(
		public readonly string $name,
		public readonly int $id,
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
			id: $json['id'],
		);
	}

}
