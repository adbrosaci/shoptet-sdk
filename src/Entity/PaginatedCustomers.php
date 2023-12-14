<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Nette\Utils\Arrays;

class PaginatedCustomers
{

	/**
	 * @param array<CustomerLight> $customers
	 */
	public function __construct(
		public readonly array $customers,
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
			customers: Arrays::map(
				$json['customers'],
				fn (array $customerJson): CustomerLight => CustomerLight::fromJson($customerJson),
			),
			paginator: Paginator::fromJson($json['paginator']),
		);
	}

}
