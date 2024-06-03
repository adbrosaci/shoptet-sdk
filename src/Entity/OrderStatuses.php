<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Nette\Utils\Arrays;

class OrderStatuses
{

	/**
	 * @param array<OrderStatus> $statuses
	 */
	public function __construct(
		public readonly int $defaultStatus,
		public readonly array $statuses,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			defaultStatus: $json['defaultStatus'],
			statuses: Arrays::map(
				$json['statuses'],
				fn (array $status): OrderStatus => OrderStatus::fromJson($status),
			),
		);
	}

}
