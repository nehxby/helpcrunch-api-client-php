<?php

namespace Helpcrunch\PublicApi\Tools;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Helpcrunch\PublicApi\Agents;
use Helpcrunch\PublicApi\Applications;
use Helpcrunch\PublicApi\Chats;
use Helpcrunch\PublicApi\Customers;
use Helpcrunch\PublicApi\Departments;

class Client
{
	protected const int INVALID_KEY_CODE = 401;
	protected const int NOT_FOUND_CODE = 404;
	protected const int TOO_MANY_REQUESTS = 429;
	protected const string DEFAULT_DOMAIN = 'com';
	protected const string DEFAULT_SCHEMA = 'https://';

	private array $headers = [];

	protected GuzzleClient $client;


	protected ?Customers $customers = NULL;
	protected ?Chats $chats = NULL;
	protected ?Agents $agents = NULL;
	protected ?Departments $departments = NULL;
	protected ?Applications $applications = NULL;

	/**
	 * @param string $organizationDomain
	 * @param string $privateKey
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

		$this->client = new GuzzleClient([
			'base_uri' => HELPCRUNCH_PUBLIC_API_SCHEMA . 'api.helpcrunch.' . HELPCRUNCH_PUBLIC_API_DOMAIN . '/v1/',
		]);
		$this->headers = [
			'Authorization' => 'Bearer <' . $privateKey . '>',
		];
	}

	/**
	 * @throws GuzzleException
	 */
	public function request($method, $uri = '', array $options = [])
	{
		$options['headers'] = $this->headers;

		try {
			/**
			 * @var Response $response
			 */
			$response = $this->client->request($method, $uri, $options);
			return $this->handleResponse($response);
		} catch (ClientException $exception) {
			$response = $exception->getResponse();
			switch ($response->getStatusCode()) {
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
	}

	/**
	 * @param Response $response
	 *
	 * @return mixed
	 */
	private function handleResponse(Response $response): mixed
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
