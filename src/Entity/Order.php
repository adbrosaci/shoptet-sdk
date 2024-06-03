<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\VatMode;
use DateTimeImmutable;
use Nette\Utils\Arrays;

class Order
{

	/**
	 * @param array<OrderItem> $items
	 */
	public function __construct(
		public readonly string $code,
		public readonly ?string $guid,
		public readonly ?string $externalCode,
		public readonly DateTimeImmutable $creationTime,
		public readonly ?DateTimeImmutable $changeTime,
		public readonly ?string $email,
		public readonly ?string $phone,
		public readonly ?DateTimeImmutable $birthDate,
		public readonly bool $vatPayer,
		public readonly ?string $customerGuid,
		public readonly bool $addressesEqual,
		public readonly ?bool $cashDeskOrder,
		public readonly int $stockId,
		public readonly ?bool $paid,
		public readonly string $adminUrl,
		public readonly ?string $onlinePaymentLink,
		public readonly string $language,
		public readonly ?string $referer,
		public readonly ?OrderBillingMethod $billingMethod,
		public readonly OrderBillingAddress $billingAddress,
		public readonly ?OrderDeliveryAddress $deliveryAddress,
		public readonly OrderStatus $status,
		public readonly ?VatMode $vatMode,
		public readonly OrderSource $source,
		public readonly OrderPrice $price,
		public readonly ?OrderPaymentMethod $paymentMethod,
		public readonly OrderShipping $shipping,
		public readonly ?string $clientIPAddress,
		// @todo add missing properties
		public readonly array $items,
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
			externalCode: $json['externalCode'],
			creationTime: new DateTimeImmutable($json['creationTime']),
			changeTime: $json['changeTime'] !== null
				? new DateTimeImmutable($json['changeTime'])
				: null,
			email: $json['email'],
			phone: $json['phone'],
			birthDate: $json['birthDate'] !== null
				? new DateTimeImmutable($json['birthDate'])
				: null,
			vatPayer: $json['vatPayer'],
			customerGuid: $json['customerGuid'],
			addressesEqual: $json['addressesEqual'],
			cashDeskOrder: $json['cashDeskOrder'],
			stockId: $json['stockId'],
			paid: $json['paid'],
			adminUrl: $json['adminUrl'],
			onlinePaymentLink: $json['onlinePaymentLink'],
			language: $json['language'],
			referer: $json['referer'],
			billingMethod: $json['billingMethod'] !== null
				? OrderBillingMethod::fromJson($json['billingMethod'])
				: null,
			billingAddress: OrderBillingAddress::fromJson($json['billingAddress']),
			deliveryAddress: $json['deliveryAddress'] !== null
				? OrderDeliveryAddress::fromJson($json['deliveryAddress'])
				: null,
			status: OrderStatus::fromJson($json['status']),
			vatMode: $json['vatMode'] !== null
				? VatMode::from($json['vatMode'])
				: null,
			source: OrderSource::fromJson($json['source']),
			price: OrderPrice::fromJson($json['price']),
			paymentMethod: $json['paymentMethod'] !== null
				? OrderPaymentMethod::fromJson($json['paymentMethod'])
				: null,
			shipping: OrderShipping::fromJson($json['shipping']),
			clientIPAddress: $json['clientIPAddress'],
			// @todo add missing properties
			items: Arrays::map(
				$json['items'],
				fn (array $item): OrderItem => OrderItem::fromJson($item),
			),
		);
	}

}
