<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use DateTimeImmutable;

class OrderLight
{

	public function __construct(
		public readonly string $code,
		public readonly ?string $guid,
		public readonly DateTimeImmutable $creationTime,
		public readonly ?DateTimeImmutable $changeTime,
		public readonly ?string $fullName,
		public readonly ?string $company,
		public readonly ?string $email,
		public readonly ?string $phone,
		public readonly ?OrderStatusLight $status,
		public readonly ?OrderSource $source,
		public readonly ?OrderShipping $shipping,
		public readonly ?OrderPaymentMethod $paymentMethod,
		public readonly ?string $remark,
		public readonly ?string $customerGuid,
		public readonly OrderPrice $price,
		public readonly ?bool $paid,
		public readonly ?bool $cashDeskOrder,
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
			code: $json['code'],
			guid: $json['guid'],
			creationTime: new DateTimeImmutable($json['creationTime']),
			changeTime: $json['changeTime'] !== null
				? new DateTimeImmutable($json['changeTime'])
				: null,
			fullName: $json['fullName'],
			company: $json['company'],
			email: $json['email'],
			phone: $json['phone'],
			status: $json['status'] !== null
				? OrderStatusLight::fromJson($json['status'])
				: null,
			source: $json['source'] !== null
				? OrderSource::fromJson($json['source'])
				: null,
			shipping: $json['shipping'] !== null
				? OrderShipping::fromJson($json['shipping'])
				: null,
			paymentMethod: $json['paymentMethod'] !== null
				? OrderPaymentMethod::fromJson($json['paymentMethod'])
				: null,
			remark: $json['remark'],
			customerGuid: $json['customerGuid'],
			price: OrderPrice::fromJson($json['price']),
			paid: $json['paid'],
			cashDeskOrder: $json['cashDeskOrder'],
			adminUrl: $json['adminUrl'],
		);
	}

}
