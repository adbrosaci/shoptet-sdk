<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use DateTimeImmutable;
use Nette\Utils\Arrays;

class Customer
{

	/**
	 * @param array<CustomerAccount> $accounts
	 */
	public function __construct(
		public readonly string $guid,
		public readonly DateTimeImmutable $changeTime,
		public readonly DateTimeImmutable $creationTime,
		public readonly ?DateTimeImmutable $birthDate,
		public readonly bool $disabledOrders,
		public readonly array $accounts,
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
			creationTime: new DateTimeImmutable($json['creationTime']),
			birthDate: $json['birthDate'] !== null
				? new DateTimeImmutable($json['birthDate'])
				: null,
			disabledOrders: $json['disabledOrders'],
			accounts: Arrays::map(
				$json['accounts'],
				fn (array $accountJson): CustomerAccount => CustomerAccount::fromJson($accountJson),
			),
			adminUrl: $json['adminUrl'],
		);
	}

}
