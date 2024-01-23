<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OAuthAccessToken
{

	public function __construct(
		public readonly string $accessToken,
		public readonly ?int $expiresIn,
		public readonly string $tokenType,
		public readonly string $scope,
		public readonly int $eshopId,
		public readonly string $eshopUrl,
		public readonly string $contactEmail,
		public readonly bool $trial,
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
			eshopId: $json['eshopId'],
			eshopUrl: $json['eshopUrl'],
			contactEmail: $json['contactEmail'],
			trial: $json['trial'],
		);
	}

}
