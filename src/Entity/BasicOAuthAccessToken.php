<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class BasicOAuthAccessToken
{

	public function __construct(
		public readonly string $accessToken,
		public readonly ?int $expiresIn,
		public readonly string $tokenType,
		public readonly string $scope,
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
			tokenType: $json['token_type'],
			scope: $json['scope'],
		);
	}

}
