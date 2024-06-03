<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\OrderItemType;

class OrderItem
{

	public function __construct(
		public readonly ?string $productGuid,
		public readonly ?string $code,
		public readonly OrderItemType $itemType,
		public readonly string $name,
		public readonly ?string $variantName,
		public readonly ?int $ean,
		public readonly ?string $brand,
		public readonly ?string $supplierName,
		public readonly ?string $remark,
		public readonly ?string $weight,
		public readonly ?string $additionalField,
		public readonly string $amount,
		public readonly ?string $amountUnit,
		public readonly ?string $amountCompleted,
		public readonly ?string $priceRatio,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			productGuid: $json['productGuid'],
			code: $json['code'],
			itemType: OrderItemType::from($json['itemType']),
			name: $json['name'],
			variantName: $json['variantName'],
			ean: $json['ean'],
			brand: $json['brand'],
			supplierName: $json['supplierName'],
			remark: $json['remark'],
			weight: $json['weight'],
			additionalField: $json['additionalField'],
			amount: $json['amount'],
			amountUnit: $json['amountUnit'],
			amountCompleted: $json['amountCompleted'],
			priceRatio: $json['priceRatio'],
		);
	}

}
