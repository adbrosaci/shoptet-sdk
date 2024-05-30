<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Request;

use Adbros\Shoptet\Enum\Currency;
use Adbros\Shoptet\Enum\DiscountType;
use Adbros\Shoptet\Enum\ShippingPrice;
use DateTimeImmutable;
use InvalidArgumentException;

class DiscountCouponRequest
{

	public function __construct(
		public readonly string $code,
		public readonly DiscountType $discountType,
		public readonly string $template,
		public readonly ?float $amount = null,
		public readonly ?float $ratio = null,
		public readonly ?float $minPrice = null,
		public readonly ?Currency $currency = null,
		public readonly ShippingPrice $shippingPrice = ShippingPrice::Cart,
		public readonly ?DateTimeImmutable $validFrom = null,
		public readonly ?DateTimeImmutable $validTo = null,
		public readonly bool $reusable = false,
		public readonly ?string $remark = null,
	)
	{
		if ($discountType === DiscountType::Percentual) {
			if ($ratio === null) {
				throw new InvalidArgumentException('Ratio must be set for percentual discount type.');
			}
		} else {
			if ($amount === null) {
				throw new InvalidArgumentException('Amount must be set for fixed discount type.');
			}
		}
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array
	{
		$array = [
			'code' => $this->code,
			'discountType' => $this->discountType->value,
			'minPrice' => $this->minPrice !== null
				? number_format($this->minPrice, 2, '.', '')
				: null,
			'currency' => $this->currency?->value,
			'template' => $this->template,
			'shippingPrice' => $this->shippingPrice->value,
			'validFrom' => $this->validFrom?->format('Y-m-d'),
			'validTo' => $this->validTo?->format('Y-m-d'),
			'reusable' => $this->reusable,
			'remark' => $this->remark,
		];

		return $array + match ($this->discountType) {
			DiscountType::Fixed => [
				'amount' => number_format($this->amount, 2, '.', ''), // @phpstan-ignore-line
			],
			DiscountType::Percentual => [
				'ratio' => number_format($this->ratio, 4, '.', ''), // @phpstan-ignore-line
			],
		};
	}

}
