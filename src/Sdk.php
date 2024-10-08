<?php declare(strict_types = 1);

namespace Adbros\Shoptet;

use Adbros\Shoptet\Entity\Customer;
use Adbros\Shoptet\Entity\DiscountCoupon;
use Adbros\Shoptet\Entity\DiscountCouponTemplate;
use Adbros\Shoptet\Entity\EshopInfo;
use Adbros\Shoptet\Entity\Order;
use Adbros\Shoptet\Entity\OrderStatuses;
use Adbros\Shoptet\Entity\PaginatedCustomers;
use Adbros\Shoptet\Entity\PaginatedOrders;
use Adbros\Shoptet\Entity\PaginatedWebhooks;
use Adbros\Shoptet\Entity\TemplateSnippet;
use Adbros\Shoptet\Entity\Webhooks;
use Adbros\Shoptet\Enum\Event;
use Adbros\Shoptet\Enum\SnippetLocation;
use Adbros\Shoptet\Exception\ClientException;
use Adbros\Shoptet\Exception\ServerException;
use Adbros\Shoptet\Request\DiscountCouponRequest;
use Adbros\Shoptet\Request\DiscountCouponsSetRequest;
use Adbros\Shoptet\Request\TemplateSnippetRequest;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Nette\Utils\Arrays;
use Nette\Utils\Json;

class Sdk
{

	private Client $httpClient;

	public function __construct(
		string $apiAccessToken,
		string $apiBaseUri = 'https://api.myshoptet.com/api/',
	)
	{
		$this->httpClient = new Client([
			'base_uri' => $apiBaseUri,
			'headers' => [
				'Shoptet-Access-Token' => $apiAccessToken,
				'Content-Type' => 'application/vnd.shoptet.v1.0',
			],
		]);
	}

	public function getCustomers(
		int $page = 1,
		int $itemsPerPage = 20,
	): PaginatedCustomers
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'customers', [
			'query' => [
				'page' => $page,
				'itemsPerPage' => $itemsPerPage,
			],
		]);

		return PaginatedCustomers::fromJson($response);
	}

	public function getCustomer(string $guid): Customer
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', sprintf('customers/%s', $guid));

		return Customer::fromJson($response['customer']);
	}

	public function getWebhooks(
		int $page = 1,
		int $itemsPerPage = 20,
	): PaginatedWebhooks
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'webhooks', [
			'query' => [
				'page' => $page,
				'itemsPerPage' => $itemsPerPage,
			],
		]);

		return PaginatedWebhooks::fromJson($response);
	}

	/**
	 * @param Event|array<Event> $event
	 */
	public function createWebhook(Event|array $event, string $url): Webhooks
	{
		if (!is_array($event)) {
			$event = [$event];
		}

		/** @var array<string, mixed> $response */
		$response = $this->request('post', 'webhooks', [
			'body' => json_encode([
				'data' => Arrays::map($event, fn (Event $e): array => [
					'event' => $e->value,
					'url' => $url,
				]),
			]),
		]);

		return Webhooks::fromJson($response);
	}

	public function deleteWebhook(int $id): void
	{
		$this->request('delete', sprintf('webhooks/%d', $id));
	}

	/**
	 * @param array<DiscountCouponRequest> $discountCouponRequests
	 * @return array<DiscountCoupon>
	 */
	public function createDiscountCoupons(array $discountCouponRequests): array
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('post', 'discount-coupons', [
			'body' => json_encode([
				'data' => [
					'coupons' => Arrays::map($discountCouponRequests, fn (DiscountCouponRequest $d): array => $d->toArray()),
				],
			]),
		]);

		return Arrays::map($response['coupons'], fn (array $c): DiscountCoupon => DiscountCoupon::fromJson($c));
	}

	/**
	 * @return array<DiscountCoupon>
	 */
	public function createDiscountCouponsSet(DiscountCouponsSetRequest $discountCouponsSetRequest): array
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('post', 'discount-coupons/set', [
			'body' => json_encode([
				'data' => $discountCouponsSetRequest->toArray(),
			]),
		]);

		return Arrays::map($response['coupons'], fn (array $c): DiscountCoupon => DiscountCoupon::fromJson($c));
	}

	/**
	 * @return array<DiscountCouponTemplate>
	 */
	public function getDiscountCouponTemplates(): array
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'discount-coupons/templates');

		return Arrays::map($response['couponTemplates'], fn (array $t): DiscountCouponTemplate => DiscountCouponTemplate::fromJson($t));
	}

	/**
	 * @param array<string> $include
	 */
	public function getOrder(
		string $code,
		array $include = [],
	): Order
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', sprintf('orders/%s', $code), [
			'query' => [
				'include' => $include,
			],
		]);

		return Order::fromJson($response['order']);
	}

	public function getOrders(
		int $page = 1,
		int $itemsPerPage = 20,
		?int $statusId = null,
		?string $shippingGuid = null,
		?string $shippingCompanyCode = null,
		?string $paymentMethodGuid = null,
		?DateTimeImmutable $creationTimeFrom = null,
		?DateTimeImmutable $creationTimeTo = null,
		?string $codeFrom = null,
		?string $codeTo = null,
		?string $customerGuid = null,
		?string $email = null,
		?string $phone = null,
		?string $productCode = null,
		?DateTimeImmutable $changeTimeFrom = null,
		?DateTimeImmutable $changeTimeTo = null,
		?string $sourceId = null,
	): PaginatedOrders
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'orders', [
			'query' => [
				'page' => $page,
				'itemsPerPage' => $itemsPerPage,
				'statusId' => $statusId !== null
					? (string) $statusId
					: null,
				'shippingGuid' => $shippingGuid,
				'shippingCompanyCode' => $shippingCompanyCode,
				'paymentMethodGuid' => $paymentMethodGuid,
				'creationTimeFrom' => $creationTimeFrom?->format('c'),
				'creationTimeTo' => $creationTimeTo?->format('c'),
				'codeFrom' => $codeFrom,
				'codeTo' => $codeTo,
				'customerGuid' => $customerGuid,
				'email' => $email,
				'phone' => $phone,
				'productCode' => $productCode,
				'changeTimeFrom' => $changeTimeFrom?->format('c'),
				'changeTimeTo' => $changeTimeTo?->format('c'),
				'sourceId' => $sourceId,
			],
		]);

		return PaginatedOrders::fromJson($response);
	}

	public function getOrderStatuses(): OrderStatuses
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'orders/statuses');

		return OrderStatuses::fromJson($response);
	}

	public function getEshopInfo(
		bool $orderAdditionalFields = false,
		bool $orderStatuses = false,
		bool $paymentMethods = false,
		bool $shippingMethods = false,
		bool $imageCuts = false,
		bool $countries = false,
		bool $cashDesk = false,
	): EshopInfo
	{
		$include = [];

		if ($orderAdditionalFields) {
			$include[] = 'orderAdditionalFields';
		}

		if ($orderStatuses) {
			$include[] = 'orderStatuses';
		}

		if ($paymentMethods) {
			$include[] = 'paymentMethods';
		}

		if ($shippingMethods) {
			$include[] = 'shippingMethods';
		}

		if ($imageCuts) {
			$include[] = 'imageCuts';
		}

		if ($countries) {
			$include[] = 'countries';
		}

		if ($cashDesk) {
			$include[] = 'cashDesk';
		}

		/** @var array<string, mixed> $response */
		$response = $this->request('get', 'eshop', [
			'query' => $include !== [] ? [
				'include' => implode(',', $include),
			] : [],
		]);

		return EshopInfo::fromJson($response);
	}

	/**
	 * @param array<TemplateSnippetRequest> $snippets
	 * @return array<TemplateSnippet>
	 */
	public function setTemplateInclude(array $snippets): array
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('post', 'template-include', [
			'body' => json_encode([
				'data' => [
					'snippets' => Arrays::map($snippets, fn (TemplateSnippetRequest $s): array => $s->toArray()),
				],
			]),
		]);

		return Arrays::map($response['snippets'], fn (array $t): TemplateSnippet => TemplateSnippet::fromJson($t));
	}

	public function deleteTemplateInclude(SnippetLocation $location): void
	{
		$this->request('delete', 'template-include/' . $location->value);
	}

	public function generateSignatureKey(): string
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('post', 'webhooks/renew-signature-key');

		return $response['signatureKey'];
	}

	/**
	 * @param array<string, mixed> $options
	 * @return array<string, mixed>
	 */
	private function request(string $method, string $uri, array $options = []): ?array
	{
		try {
			$response = $this->httpClient->request($method, $uri, $options);
		} catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException $e) {
			$class = $e instanceof \GuzzleHttp\Exception\ClientException
				? ClientException::class
				: ServerException::class;
			$json = Json::decode($e->getResponse()->getBody()->getContents(), Json::FORCE_ARRAY);

			throw new $class('', $e->getCode(), $e, $json['errors'] ?? []);
		}

		$json = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);

		return $json['data'];
	}

}
