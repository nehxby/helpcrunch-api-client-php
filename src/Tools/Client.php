<?php

namespace Helpcrunch\PublicApi\Tools;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Helpcrunch\PublicApi\Agents;
use Helpcrunch\PublicApi\Chats;
use Helpcrunch\PublicApi\Customers;
use Helpcrunch\PublicApi\Departments;

class Client extends GuzzleClient
{
	const INVALID_KEY_CODE = 401;
	const NOT_FOUND_CODE = 404;
	const TOO_MANY_REQUESTS = 429;
	const DEFAULT_DOMAIN = 'com';
	const DEFAULT_SCHEMA = 'https://';

	/**
	 * @var array
	 */
	private $headers = [];


	protected $customers;
	protected $chats;
	protected $agents;
	protected $departments;
	protected $applications;

	/**
	 * @param string|null $organizationDomain
	 * @param string|null $privateKey
	 */
	public function __construct(string $organizationDomain, string $privateKey)
	{
		if (empty($organizationDomain)) {
			throw new \InvalidArgumentException('You need to specify your organization\'s domain');
		}
		if (empty($privateKey)) {
			throw new \InvalidArgumentException('You need to specify your organization\'s private API key');
		}
		if (!defined('HELPCRUNCH_PUBLIC_API_SCHEMA')) {
			define('HELPCRUNCH_PUBLIC_API_SCHEMA', static::DEFAULT_SCHEMA);
		}
		if (!defined('HELPCRUNCH_PUBLIC_API_DOMAIN')) {
			define('HELPCRUNCH_PUBLIC_API_DOMAIN', static::DEFAULT_DOMAIN);
		}

		parent::__construct([
			'base_uri' => HELPCRUNCH_PUBLIC_API_SCHEMA . 'api.helpcrunch.' . HELPCRUNCH_PUBLIC_API_DOMAIN . '/v1/',
		]);
		$this->headers = [
			'Authorization' => 'Bearer <' . $privateKey . '>',
		];
	}

	public function request($method, $uri = '', array $options = [])
	{
		$options['headers'] = $this->headers;
		try {
			$response = parent::request($method, $uri, $options);
			if ($response) return $this->handleResponse($response);
		} catch (ClientException $exception) {
			switch ($exception->getCode()) {
				case self::INVALID_KEY_CODE:
					throw new \InvalidArgumentException('Invalid HelpCrunch API private key or organization domain');
				case self::TOO_MANY_REQUESTS:
					throw new \InvalidArgumentException(
						'You are make too much or too big queries.' .
						'You can check limits here: https://docs.helpcrunch.com/backend-api-reference.html#limitations'
					);
				case self::NOT_FOUND_CODE:
					throw new \InvalidArgumentException('Invalid endpoint or unsupported API usage. URI: ' . $uri);
				default:
					throw $exception;
			}
		}

		return $response;
	}

	/**
	 * @param Response $response
	 *
	 * @return mixed
	 */
	private function handleResponse(Response $response)
	{
		if ($body = $response->getBody()->getContents()) {
			return json_decode($body, TRUE, 512, JSON_UNESCAPED_UNICODE);
		}
		return NULL;
	}


	public function getCustomers(): Customers
	{
		if (!$this->customers) {
			$this->customers = new Customers($this);
		}

		return $this->customers;
	}

	public function getChats(): Chats
	{
		if (!$this->chats) {
			$this->chats = new Chats($this);
		}

		return $this->chats;
	}

	public function getAgents(): Agents
	{
		if (!$this->agents) {
			$this->agents = new Agents($this);
		}

		return $this->agents;
	}

	public function getDepartments(): Departments
	{
		if (!$this->departments) {
			$this->departments = new Departments($this);
		}

		return $this->departments;
	}

	public function getApplications(): Applications
	{
		if (!$this->applications) {
			$this->applications = new Applications($this);
		}

		return $this->applications;
	}

}
