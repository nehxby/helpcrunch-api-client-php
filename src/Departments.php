<?php

namespace Helpcrunch\PublicApi;


use Helpcrunch\PublicApi\Tools\BasicAPIResource;

class Departments extends BasicAPIResource
{
	/**
	 * @var string
	 */
	protected static $endpoint = 'departments';


	public function organization(): ?array
	{
		return $this->request('GET', 'organization');
	}

}
