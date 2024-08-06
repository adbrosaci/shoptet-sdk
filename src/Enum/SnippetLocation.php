<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum SnippetLocation: string
{

	case CommonHeader = 'common-header';
	case CommonFooter = 'common-footer';
	case OrderConfirmed = 'order-confirmed';

}
