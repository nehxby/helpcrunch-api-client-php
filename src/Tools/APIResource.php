<?php

namespace Helpcrunch\PublicApi\Tools;

abstract class APIResource extends BasicAPIResource
{

	/**
	 * @param int $id
	 * @return array|null
	 */
	public function get(int $id): ?array
	{
		return $this->request('GET', sprintf('%s/%d', static::$endpoint, $id));
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 * @param string $sort
	 * @param string $order
	 * @return array|null
	 */
	public function list(int $limit = 100, int $offset = 0, string $sort = '', string $order = 'asc'): ?array
	{
		$data = [
			'limit'  => $limit,
			'offset' => $offset,
		];
		if (!empty($sort)) {
			$data = array_merge($data, [
				'sort'  => $sort,
				'order' => $order,
			]);
		}
		return $this->request('GET', static::$endpoint, $data);
	}

	/**
	 * @param SearchFilters $filter
	 * @param int $limit
	 * @param int $offset
	 * @param string $sort
	 * @param string $order
	 * @return array|null
	 * @throws \Exception
	 */
	public function search(SearchFilters $filter, int $limit = 20, int $offset = 0, string $sort = '', string $order = 'asc'): ?array
	{
		$bodyParams = array_merge($filter->makeBodyParams(), [
			'limit'  => $limit,
			'offset' => $offset,
		]);

		if (empty($bodyParams['filter'])) {
			throw new \Exception('Filter cannot be empty');
		}

		if (!empty($sort)) {
			$bodyParams = array_merge($bodyParams, [
				'sort'  => $sort,
				'order' => $order,
			]);
		}

		return $this->request('POST', static::$endpoint . '/search', [
			'body' => json_encode($bodyParams)
		]);
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	protected function create(array $data): ?array
	{
		return $this->request('POST', static::$endpoint, [
			'body' => json_encode($data)
		]);
	}

}
