<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class BasicEshop
{

	public function __construct(
		public readonly BasicEshopUser $user,
		public readonly BasicEshopProject $project,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			user: BasicEshopUser::fromJson($json['user']),
			project: BasicEshopProject::fromJson($json['project']),
		);
	}

}
