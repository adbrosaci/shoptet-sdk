<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderStatusDocuments
{

	public function __construct(
		public readonly bool $generateProformaInvoice,
		public readonly bool $generateInvoice,
		public readonly bool $generateDeliveryNote,
		public readonly bool $generateProofPayment,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			generateProformaInvoice: $json['generateProformaInvoice'],
			generateInvoice: $json['generateInvoice'],
			generateDeliveryNote: $json['generateDeliveryNote'],
			generateProofPayment: $json['generateProofPayment'],
		);
	}

}
