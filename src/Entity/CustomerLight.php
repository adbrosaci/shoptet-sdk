<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use DateTimeImmutable;

class CustomerLight
{

	public function __construct(
		public string $guid,
		public DateTimeImmutable $changeTime,
		public readonly ?string $billCompany,
		public readonly string $billFullName,
		public readonly DateTimeImmutable $creationTime,
		public readonly string $adminUrl,
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
			changeTime: new DateTimeImmutable($json['changeTime']),
			billCompany: $json['billCompany'],
			billFullName: $json['billFullName'],
			creationTime: new DateTimeImmutable($json['creationTime']),
			adminUrl: $json['adminUrl'],
		);
	}

}
