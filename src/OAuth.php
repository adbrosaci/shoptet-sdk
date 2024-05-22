<?php declare(strict_types = 1);

namespace Adbros\Shoptet;

use Adbros\Shoptet\Entity\ApiAccessToken;
use Adbros\Shoptet\Entity\BasicEshop;
use Adbros\Shoptet\Entity\BasicOAuthAccessToken;
use Adbros\Shoptet\Entity\OAuthAccessToken;
use Adbros\Shoptet\Exception\ClientException;
use Adbros\Shoptet\Exception\ServerException;
use GuzzleHttp\Client;
use Nette\Utils\Json;

class OAuth
{

	private Client $httpClient;

	private readonly string $oAuthAccessTokenUrl;

	private readonly string $apiAccessTokenUrl;

	public function __construct(
		private readonly string $clientId,
		private readonly string $clientSecret,
		private readonly string $eshopUrl,
	)
	{
		$this->httpClient = new Client();

		$this->oAuthAccessTokenUrl = rtrim($this->eshopUrl, '/') . '/action/ApiOAuthServer/token';
		$this->apiAccessTokenUrl = rtrim($this->eshopUrl, '/') . '/action/ApiOAuthServer/getAccessToken';
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

	public function getBasicLoginUrl(string $redirectUri, ?string $baseOAuthUrl = null, ?string $state = null): string
	{
		$params = [
			'client_id' => $this->clientId,
			'scope' => 'basic_eshop',
			'response_type' => 'code',
			'redirect_uri' => $redirectUri,
		];

		if ($state !== null) {
			$params['state'] = $state;
		}

		return $this->getBasicOAuthUrl($baseOAuthUrl) . 'authorize?' . http_build_query($params);
	}

	public function getBasicOAuthAccessToken(string $code, string $redirectUri, ?string $baseOAuthUrl = null): BasicOAuthAccessToken // @phpcs:ignore Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
	{
		$oAuthUrl = $this->getBasicOAuthUrl($baseOAuthUrl) . 'token';

		/** @var array<string, mixed> $response */
		$response = $this->request('POST', $oAuthUrl, [
			'json' => [
				'client_id' => $this->clientId,
				'client_secret' => $this->clientSecret,
				'code' => $code,
				'grant_type' => 'authorization_code',
				'redirect_uri' => $redirectUri,
				'scope' => 'basic_eshop',
			],
		]);

		return BasicOAuthAccessToken::fromJson($response);
	}

	public function getBasicEshop(string $basicOAuthAccessToken, ?string $baseOAuthUrl = null): BasicEshop
	{
		$oAuthUrl = $this->getBasicOAuthUrl($baseOAuthUrl) . 'resource';

		/** @var array<string, mixed> $response */
		$response = $this->request('POST', $oAuthUrl, [
			'headers' => [
				'Authorization' => sprintf('Bearer %s', $basicOAuthAccessToken),
			],
			'query' => [
				'method' => 'getBasicEshop',
			],
		]);

		return BasicEshop::fromJson($response['data']);
	}

	private function getBasicOAuthUrl(?string $baseOAuthUrl): string // @phpcs:ignore Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
	{
		if ($baseOAuthUrl === null) {
			$baseOAuthUrl = rtrim($this->eshopUrl, '/') . '/action/OAuthServer/';
		}

		return $baseOAuthUrl;
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
