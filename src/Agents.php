<?php

namespace Helpcrunch\PublicApi;


use Helpcrunch\PublicApi\Tools\BasicAPIResource;

class Agents extends BasicAPIResource
{

	/**
	 * @var string
	 */
	protected static $endpoint = 'agents';

	/**
	 * @param int $id
	 * @return array|null
	 */
	public function unsubscribe(int $id): ?array
	{
		return $this->request('GET', sprintf('%s/%d/%s', static::$endpoint, $id, 'unsubscribe'));
	}

}
