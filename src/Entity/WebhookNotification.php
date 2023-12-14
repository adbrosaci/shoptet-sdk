<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\Event;
use DateTimeImmutable;

class WebhookNotification
{

	public function __construct(
		public readonly int $eshopId,
		public readonly Event $event,
		public readonly DateTimeImmutable $eventCreated,
		public readonly string $eventInstance,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			eshopId: $json['eshopId'],
			event: Event::from($json['event']),
			eventCreated: new DateTimeImmutable($json['eventCreated']),
			eventInstance: $json['eventInstance'],
		);
	}

}
