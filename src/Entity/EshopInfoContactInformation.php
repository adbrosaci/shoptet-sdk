<?php declare(strict_types = 1);

namespace Adbros\Shoptet\Entity;

class EshopInfoContactInformation
{

	public function __construct(
		public readonly int $eshopId,
		public readonly string $eshopName,
		public readonly string $eshopTitle,
		public readonly string $eshopCategory,
		public readonly ?string $eshopSubtitle,
		public readonly string $url,
		public readonly ?string $contactPerson,
		public readonly string $email,
		public readonly ?string $phone,
		public readonly ?string $mobilePhone,
		public readonly ?string $skypeAccount,
		public readonly ?string $contactPhotoUrl,
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
			eshopName: $json['eshopName'],
			eshopTitle: $json['eshopTitle'],
			eshopCategory: $json['eshopCategory'],
			eshopSubtitle: $json['eshopSubtitle'],
			url: $json['url'],
			contactPerson: $json['contactPerson'],
			email: $json['email'],
			phone: $json['phone'],
			mobilePhone: $json['mobilePhone'],
			skypeAccount: $json['skypeAccount'],
			contactPhotoUrl: $json['contactPhotoUrl'],
		);
	}

}
