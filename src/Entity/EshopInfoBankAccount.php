<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class EshopInfoBankAccount
{

	public function __construct(
		public readonly string $accountNumber,
		public readonly ?string $iban,
		public readonly ?string $bic,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			accountNumber: $json['accountNumber'],
			iban: $json['iban'],
			bic: $json['bic'],
		);
	}

}
