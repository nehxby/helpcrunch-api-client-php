<?php

namespace Helpcrunch\PublicApi;


use Helpcrunch\PublicApi\Tools\APIResource;
use Helpcrunch\PublicApi\Tools\SearchFilters;

class Chats extends APIResource
{

	const SORT_CREATED_AT = 'chats.createdAt';
	const SORT_LAST_CUST_MSG_AT = 'chats.lastCustomerMessageAt';
	const SORT_LAST_MSG_AT = 'chats.lastMessageAt';
	const SORT_CLOSED_AT = 'chats.closedAt';


	/**
	 * @var string
	 */
	protected static $endpoint = 'chats';

	/**
	 * documented but not work
	 * @return array|null
	 */
	private function count(): ?array
	{
		return $this->request('GET', sprintf('%s/%s', static::$endpoint, 'total'));
	}

	public function list(int $limit = 100, int $offset = 0, string $sort = self::SORT_CREATED_AT, string $order = 'asc'): ?array
	{
		return parent::list($limit, $offset, $sort, $order);
	}

	public function search(SearchFilters $filter, int $limit = 20, int $offset = 0, string $sort = self::SORT_LAST_CUST_MSG_AT, string $order = 'asc'): ?array
	{
		return parent::search($filter, $limit, $offset, $sort, $order);
	}

	/**
	 * @param int $customer
	 * @param int $application
	 * @param int|NULL $assignee
	 * @param int|NULL $department
	 * @return array|null
	 */
	public function add(int $customer, int $application, int $assignee = NULL, int $department = NULL): ?array
	{
		$data = [
			'customer'    => $customer,
			'application' => $application,
		];
		if ($assignee) $data['assignee'] = $assignee;
		if ($department) $data['department'] = $department;

		return parent::create($data);
	}


	public function messages(int $chatId, int $limit = 100, int $offset = 0): ?array
	{
		return $this->request('GET', sprintf('%s/%s/%s', static::$endpoint, $chatId, 'messages'), [
			'limit'  => $limit,
			'offset' => $offset,
		]);
	}

	/**
	 * @param int $chatId
	 * @param string $text
	 * @param int|NULL $agent
	 * @param string|NULL $markdownText
	 * @return array|null
	 */
	public function addMessage(int $chatId, string $text, ?int $agent = NULL, string $markdownText = NULL): ?array
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
	 * @param int $id
	 * @param int $time
	 * @return array|null
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
	 * @param int $id
	 * @return array|null
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
	 * @param int $id
	 * @param string $status
	 * @return array|null
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
	 * @param int $id
	 * @param int $assignee
	 * @return array|null
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
	 * @param int $id
	 * @param int $department
	 * @return array|null
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
