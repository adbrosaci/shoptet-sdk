<?php declare(strict_types = 1);

namespace Adbros\Shoptet;

use Adbros\Shoptet\Entity\Customer;
use Adbros\Shoptet\Entity\PaginatedCustomers;
use Adbros\Shoptet\Entity\PaginatedWebhooks;
use Adbros\Shoptet\Entity\Webhooks;
use Adbros\Shoptet\Enum\Event;
use Adbros\Shoptet\Exception\ClientException;
use Adbros\Shoptet\Exception\ServerException;
use GuzzleHttp\Client;
use Nette\Utils\Arrays;
use Nette\Utils\Json;

class Sdk
{

	private Client $httpClient;

	public function __construct(
		string $apiBaseUri,
		string $apiAccessToken,
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
