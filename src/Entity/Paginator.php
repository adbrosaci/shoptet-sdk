<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class Paginator
{

	public function __construct(
		public readonly int $totalCount,
		public readonly int $page,
		public readonly int $pageCount,
		public readonly int $itemsOnPage,
		public readonly int $itemsPerPage,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			totalCount: $json['totalCount'],
			page: $json['page'],
			pageCount: $json['pageCount'],
			itemsOnPage: $json['itemsOnPage'],
			itemsPerPage: $json['itemsPerPage'],
		);
	}

}
