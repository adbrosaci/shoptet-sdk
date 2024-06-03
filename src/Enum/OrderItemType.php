<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum OrderItemType: string
{

	case Product = 'product';
	case Bazar = 'bazar';
	case Service = 'service';
	case Shipping = 'shipping';
	case Billing = 'billing';
	case DiscountCoupon = 'discount-coupon';
	case VolumeDiscount = 'volume-discount';
	case Gift = 'gift';
	case GiftCertificate = 'gift-certificate';
	case GenericItem = 'generic-item';
	case ProductSet = 'product-set';
	case ProductSetItem = 'product-set-item';
	case Deposit = 'deposit';

}
