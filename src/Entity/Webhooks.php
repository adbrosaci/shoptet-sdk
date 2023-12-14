<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Nette\Utils\Arrays;

class Webhooks
{

	/**
	 * @param array<Webhook> $webhooks
	 */
	public function __construct(
		public readonly array $webhooks,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			webhooks: Arrays::map(
				$json['webhooks'],
				fn (array $customerJson): Webhook => Webhook::fromJson($customerJson),
			),
		);
	}

}
