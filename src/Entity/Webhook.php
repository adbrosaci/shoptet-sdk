<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\Event;
use DateTimeImmutable;

class Webhook
{

	public function __construct(
		public readonly int $id,
		public readonly Event $event,
		public readonly string $url,
		public readonly DateTimeImmutable $created,
		public readonly ?DateTimeImmutable $updated,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			id: $json['id'],
			event: Event::from($json['event']),
			url: $json['url'],
			created: new DateTimeImmutable($json['created']),
			updated: $json['updated'] !== null
				? new DateTimeImmutable($json['updated'])
				: null,
		);
	}

}
