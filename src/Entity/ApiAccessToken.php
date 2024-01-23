<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class ApiAccessToken
{

	public function __construct(
		public readonly string $accessToken,
		public readonly int $expiresIn,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			accessToken: $json['access_token'],
			expiresIn: $json['expires_in'],
		);
	}

}
