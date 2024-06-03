<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderStatus
{

	public function __construct(
		public readonly int $id,
		public readonly string $name,
		public readonly bool $system,
		public readonly int $order,
		public readonly bool $markAsPaid,
		public readonly ?string $color,
		public readonly ?string $backgroundColor,
		public readonly bool $changeOrderItems,
		public readonly bool $stockClaimResolved,
		public readonly OrderStatusDocuments $documents,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			id: $json['id'],
			name: $json['name'],
			system: $json['system'],
			order: $json['order'],
			markAsPaid: $json['markAsPaid'],
			color: $json['color'] ?? null,
			backgroundColor: $json['backgroundColor'] ?? null,
			changeOrderItems: $json['changeOrderItems'],
			stockClaimResolved: $json['stockClaimResolved'],
			documents: OrderStatusDocuments::fromJson($json['documents']),
		);
	}

}
