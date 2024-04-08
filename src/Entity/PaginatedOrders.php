<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Nette\Utils\Arrays;

class PaginatedOrders
{

	/**
	 * @param array<Order> $orders
	 */
	public function __construct(
		public readonly array $orders,
		public readonly Paginator $paginator,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			orders: Arrays::map(
				$json['orders'],
				fn (array $json): Order => Order::fromJson($json),
			),
			paginator: Paginator::fromJson($json['paginator']),
		);
	}

}
