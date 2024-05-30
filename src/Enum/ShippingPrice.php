<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum ShippingPrice: string
{

	case BeforeDiscount = 'beforeDiscount';
	case Cart = 'cart';
	case Free = 'free';

}
