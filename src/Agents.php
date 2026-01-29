<?php

namespace Helpcrunch\PublicApi;


use GuzzleHttp\Exception\GuzzleException;
use Helpcrunch\PublicApi\Tools\BasicAPIResource;

class Agents extends BasicAPIResource
{

	protected static string $endpoint = 'agents';

	/**
	 * @param int $id
	 * @return array|null
	 * @throws GuzzleException
	 */
	public function unsubscribe(int $id): ?array
	{
		return $this->request('GET', sprintf('%s/%d/%s', static::$endpoint, $id, 'unsubscribe'));
	}

}
