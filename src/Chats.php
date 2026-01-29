<?php

namespace Helpcrunch\PublicApi;


use GuzzleHttp\Exception\GuzzleException;
use Helpcrunch\PublicApi\Tools\APIResource;
use Helpcrunch\PublicApi\Tools\SearchFilters;

class Chats extends APIResource
{

	public const string SORT_CREATED_AT = 'chats.createdAt';
	public const string SORT_LAST_CUST_MSG_AT = 'chats.lastCustomerMessageAt';
	public const string SORT_LAST_MSG_AT = 'chats.lastMessageAt';
	public const string SORT_CLOSED_AT = 'chats.closedAt';


	protected static string $endpoint = 'chats';

	/**
	 * documented but not work
	 * @throws GuzzleException
	 */
	protected function count(): ?array
	{
		return $this->request('GET', sprintf('%s/%s', static::$endpoint, 'total'));
	}

	public function list(int    $limit = 100, int $offset = 0, string $sort = self::SORT_CREATED_AT,
	                     string $order = 'asc'): ?array
	{
		return parent::list($limit, $offset, $sort, $order);
	}

	public function search(SearchFilters $filter, int $limit = 20, int $offset = 0,
	                       string        $sort = self::SORT_LAST_CUST_MSG_AT, string $order = 'asc'): ?array
	{
		return parent::search($filter, $limit, $offset, $sort, $order);
	}

	/**
	 * @throws GuzzleException
	 */
	public function add(int $customer, int $application, ?int $assignee = NULL, ?int $department = NULL): ?array
	{
		$data = [
			'customer'    => $customer,
			'application' => $application,
		];
		if ($assignee) $data['assignee'] = $assignee;
		if ($department) $data['department'] = $department;

		return parent::create($data);
	}


	/**
	 * @throws GuzzleException
	 */
	public function messages(int $chatId, int $limit = 100, int $offset = 0): ?array
	{
		return $this->request('GET', sprintf('%s/%s/%s', static::$endpoint, $chatId, 'messages'), [
			'limit'  => $limit,
			'offset' => $offset,
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function addMessage(int $chatId, string $text, ?int $agent = NULL, ?string $markdownText = NULL): ?array
	{
		$data = [
			'chat'         => $chatId,
			'agent'        => $agent,
			'type'         => 'message',
			'text'         => $text,
			'markdownText' => $markdownText ?? $text,
		];

		return $this->request('POST', 'messages', [
			'body' => json_encode($data)
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function snooze(int $id, int $time): ?array
	{
		$bodyParams = [
			'id'           => $id,
			'snoozedUntil' => $time,
		];

		return $this->request('PUT', sprintf('%s/%s', static::$endpoint, 'snooze'), [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function unSnooze(int $id): ?array
	{
		$bodyParams = [
			'id'           => $id,
			'snoozedUntil' => NULL,
		];

		return $this->request('PUT', sprintf('%s/%s', static::$endpoint, 'snooze'), [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function status(int $id, string $status): ?array
	{
		$bodyParams = [
			'id'           => $id,
			'snoozedUntil' => $status,
		];

		return $this->request('PUT', sprintf('%s/%s', static::$endpoint, 'status'), [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function assignee(int $id, int $assignee): ?array
	{
		$bodyParams = [
			'id'       => $id,
			'assignee' => $assignee,
		];

		return $this->request('PUT', sprintf('%s/%s', static::$endpoint, 'assignee'), [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @throws GuzzleException
	 */
	public function department(int $id, int $department): ?array
	{
		$bodyParams = [
			'id'         => $id,
			'department' => $department,
		];

		return $this->request('PUT', sprintf('%s/%s', static::$endpoint, 'department'), [
			'body' => json_encode($bodyParams)
		]);
	}

}
