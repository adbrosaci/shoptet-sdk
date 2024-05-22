<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class BasicEshopUser
{

	public function __construct(
		public readonly string $email,
		public readonly string $name,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			email: $json['email'],
			name: $json['name'],
		);
	}

}
