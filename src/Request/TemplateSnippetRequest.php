<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Request;

use Adbros\Shoptet\Enum\SnippetLocation;

class TemplateSnippetRequest
{

	public function __construct(
		public readonly SnippetLocation $location,
		public readonly string $html,
	)
	{
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array
	{
		return [
			'location' => $this->location->value,
			'html' => $this->html,
		];
	}

}
