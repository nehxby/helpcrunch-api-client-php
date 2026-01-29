<?php

namespace Helpcrunch\PublicApi;


use GuzzleHttp\Exception\GuzzleException;
use Helpcrunch\PublicApi\Tools\BasicAPIResource;

class Departments extends BasicAPIResource
{
	protected static string $endpoint = 'departments';


	/**
	 * @throws GuzzleException
	 */
	public function organization(): ?array
	{
		return $this->request('GET', 'organization');
	}

}
