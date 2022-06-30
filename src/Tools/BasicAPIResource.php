<?php

namespace Helpcrunch\PublicApi\Tools;

abstract class BasicAPIResource
{
	/**
	 * @var string
	 */
	protected static $endpoint;

	/**
	 * @var Client
	 */
	protected $apiClient;


	public function __construct(Client $apiClient)
	{
		$this->apiClient = $apiClient;
	}

	/**
	 * @return array|null
	 */
	public function list(/*int $limit = 100, int $offset = 0*/): ?array
	{
		return $this->request('GET', static::$endpoint, [
			//'limit'  => $limit,
			//'offset' => $offset,
		]);
	}

	/**
	 * @param string $method
	 * @param string|null $endpoint
	 * @param array $data
	 *
	 * @return array|null
	 */
	protected function request(string $method = 'GET', string $endpoint = NULL, array $data = []): ?array
	{
		return $this->apiClient->request($method, $endpoint ?? static::$endpoint, $data);
	}

}
