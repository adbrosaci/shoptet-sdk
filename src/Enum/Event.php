<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Enum;

enum Event: string
{

	case AddonApprove = 'addon:approve';
	case AddonSuspend = 'addon:suspend';
	case AddonUninstall = 'addon:uninstall';

	case CustomerCreate = 'customer:create';
	case CustomerImport = 'customer:import';

	case EshopCurrencies = 'eshop:currencies';
	case EshopBillingInformation = 'eshop:billingInformation';
	case EshopDesign = 'eshop:design';
	case EshopMandatoryFields = 'eshop:mandatoryFields';
	case EshopProjectDomain = 'eshop:projectDomain';

	case OrderCreate = 'order:create';
	case OrderDelete = 'order:delete';
	case OrderUpdate = 'order:update';

	case OrderStatusesListChange = 'orderStatusesList:change';

}
