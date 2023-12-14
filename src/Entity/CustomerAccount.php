<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class CustomerAccount
{

	public function __construct(
		public readonly string $guid,
		public readonly ?string $fullName,
		public readonly string $email,
		public readonly ?string $phone,
		public readonly bool $mainAccount,
		public readonly bool $authorized,
		public readonly bool $emailVerified,
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
			fullName: $json['fullName'],
			email: $json['email'],
			phone: $json['phone'],
			mainAccount: $json['mainAccount'],
			authorized: $json['authorized'],
			emailVerified: $json['emailVerified'],
		);
	}

}
