<?php

namespace Helpcrunch\PublicApi\Tools;

use GuzzleHttp\Exception\GuzzleException;

abstract class BasicAPIResource
{
	protected static string $endpoint;

	protected Client $apiClient;


	public function __construct(Client $apiClient)
	{
		$this->apiClient = $apiClient;
	}

	/**
	 * @return array|null
	 * @throws GuzzleException
	 */
	public function list(/*int $limit = 100, int $offset = 0*/): ?array
	{
		return $this->request('GET', static::$endpoint, [
			//'limit'  => $limit,
			//'offset' => $offset,
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	protected function request(string $method = 'GET', ?string $endpoint = NULL, array $data = []): ?array
	{
		return $this->apiClient->request($method, $endpoint ?? static::$endpoint, $data);
	}

}
