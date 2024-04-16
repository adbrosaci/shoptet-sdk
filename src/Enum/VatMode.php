<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum VatMode: string
{

	case Normal = 'Normal';
	case OneStopShop = 'One Stop Shop';
	case MiniOneStopShop = 'Mini One Stop Shop';
	case ReverseCharge = 'Reverse charge';
	case OutsideTheEU = 'Outside the EU';

}
