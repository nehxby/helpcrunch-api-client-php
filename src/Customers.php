<?php

namespace Helpcrunch\PublicApi;


use Helpcrunch\PublicApi\Tools\APIResource;
use Helpcrunch\PublicApi\Tools\SearchFilters;

class Customers extends APIResource
{

	const SORT_FIRST_SEEN = 'customers.firstSeen';
	const SORT_LAST_SEEN = 'customers.lastSeen';


	/**
	 * @var string
	 */
	protected static $endpoint = 'customers';


	public function list(int $limit = 100, int $offset = 0, string $sort = self::SORT_FIRST_SEEN, string $order = 'asc'): ?array
	{
		return parent::list($limit, $offset, $sort, $order);
	}

	public function search(SearchFilters $filter, int $limit = 20, int $offset = 0, string $sort = self::SORT_LAST_SEEN, string $order = 'asc'): ?array
	{
		return parent::search($filter, $limit, $offset, $sort, $order);
	}

	/**
	 * @param string $name
	 * @param string $email
	 * @param string $userId
	 * @param array $fields
	 * @return array|null
	 */
	public function add(string $name, string $email, string $userId = '', array $fields = []): ?array
	{
		$data = array_merge([
			'name'   => $name,
			'email'  => $email,
			'userId' => $userId,
		], $fields);

		return parent::create($data);
	}

	/**
	 * @param int $id
	 * @param array $tags example [{'name' => 'tagname', 'color => '#ccc'}, {...}]
	 * @return array|null
	 */
	public function tag(int $id, array $tags): ?array
	{
		$bodyParams = [
			'tags' => $tags,
		];

		return $this->request('PUT', sprintf('%s/%d/%s', static::$endpoint, $id, 'tags'), [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @param int $id
	 * @param array $tags example [{'name' => 'tagname'}, {...}]
	 * @return array|null
	 */
	public function untag(int $id, array $tags): ?array
	{
		$bodyParams = [
			'tags' => $tags,
		];

		return $this->request('DELETE', sprintf('%s/%d/%s', static::$endpoint, $id, 'tags'), [
			'body' => json_encode($bodyParams)
		]);
	}


	/**
	 * @param array $data
	 * @param int|NULL $id
	 * @param bool $merge
	 * @return array|null
	 * @throws \Exception
	 */
	public function update(array $data, int $id = NULL, bool $merge = TRUE): ?array
	{
		$id = $id ?? $data['id'] ?? NULL;
		if ($id === NULL) {
			throw new \Exception('Id cannot be null');
		}

		$method = $merge ? 'PATCH' : 'PUT';
		return $this->request($method, sprintf('%s/%d', static::$endpoint, $id), [
			'body' => json_encode($data)
		]);
	}

	/**
	 * @param int $id
	 * @param string $eventName
	 * @param array $data
	 * @return array|null
	 * @throws \Exception
	 */
	public function addEvent(int $id, string $eventName, array $data): ?array
	{
		if (empty($data)) {
			throw new \Exception('data value is invalid');
		}

		$bodyParams = [
			'name'     => $eventName,
			'data'     => $data,
			'customer' => $id,
		];

		return $this->request('POST', 'events', [
			'body' => json_encode($bodyParams)
		]);
	}

}
