<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class OrderDeliveryAddress
{

	public function __construct(
		public readonly ?string $company,
		public readonly ?string $fullName,
		public readonly ?string $street,
		public readonly ?string $houseNumber,
		public readonly ?string $city,
		public readonly ?string $district,
		public readonly ?string $additional,
		public readonly ?string $zip,
		public readonly ?string $countryCode,
		public readonly ?string $regionName,
		public readonly ?string $regionShortcut,
	)
	{
	}

	/**
	 * @param array<string,mixed> $json
	 */
	public static function fromJson(array $json): self
	{
		return new self(
			company: $json['company'],
			fullName: $json['fullName'],
			street: $json['street'],
			houseNumber: $json['houseNumber'],
			city: $json['city'],
			district: $json['district'],
			additional: $json['additional'],
			zip: $json['zip'],
			countryCode: $json['countryCode'],
			regionName: $json['regionName'],
			regionShortcut: $json['regionShortcut'],
		);
	}

}
