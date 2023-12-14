<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum Event: string
{

	case CustomerCreate = 'customer:create';
	case CustomerImport = 'customer:import';
	case OrderCreate = 'order:create';
	case OrderUpdate = 'order:update';
	case OrderDelete = 'order:delete';

}
