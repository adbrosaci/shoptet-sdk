<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class BasicEshopProject
{

	public function __construct(
		public readonly int $id,
		public readonly string $url,
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
			id: $json['id'],
			url: $json['url'],
			name: $json['name'],
		);
	}

}
