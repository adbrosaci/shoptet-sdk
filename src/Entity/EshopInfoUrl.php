<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class EshopInfoUrl
{

	public function __construct(
		public readonly string $ident,
		public readonly string $url,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			ident: $json['ident'],
			url: $json['url'],
		);
	}

}
