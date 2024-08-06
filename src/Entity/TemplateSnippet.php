<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

use Adbros\Shoptet\Enum\SnippetLocation;

class TemplateSnippet
{

	public function __construct(
		public readonly SnippetLocation $location,
		public readonly string $html,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			location: SnippetLocation::from($json['location']),
			html: $json['html'],
		);
	}

}
