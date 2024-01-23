<?php declare(strict_types = 1);

namespace Adbros\Shoptet;

use Adbros\Shoptet\Entity\ApiAccessToken;
use Adbros\Shoptet\Entity\OAuthAccessToken;
use Adbros\Shoptet\Exception\ClientException;
use Adbros\Shoptet\Exception\ServerException;
use GuzzleHttp\Client;
use Nette\Utils\Json;

class OAuth
{

	private Client $httpClient;

	public function __construct(
		private readonly string $clientId,
		private readonly string $clientSecret,
		private readonly string $oAuthAccessTokenUrl,
		private readonly string $apiAccessTokenUrl,
	)
	{
		$this->httpClient = new Client();
	}

	public function getOAuthAccessToken(string $code, string $redirectUri): OAuthAccessToken // @phpcs:ignore Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('POST', $this->oAuthAccessTokenUrl, [
			'json' => [
				'client_id' => $this->clientId,
				'client_secret' => $this->clientSecret,
				'code' => $code,
				'grant_type' => 'authorization_code',
				'redirect_uri' => $redirectUri,
				'scope' => 'api',
			],
		]);

		return OAuthAccessToken::fromJson($response);
	}

	public function getApiAccessToken(string $oAuthAccessToken): ApiAccessToken
	{
		/** @var array<string, mixed> $response */
		$response = $this->request('POST', $this->apiAccessTokenUrl, [
			'headers' => [
				'Authorization' => sprintf('Bearer %s', $oAuthAccessToken),
			],
		]);

		return ApiAccessToken::fromJson($response);
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

		return Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
	}

}
