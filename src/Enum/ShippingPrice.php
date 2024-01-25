<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum ShippingPrice: string
{

	case beforeDiscount = 'beforeDiscount';
	case cart = 'cart';
	case free = 'free';

}
