<?php

namespace Helpcrunch\PublicApi\Tools;

abstract class SearchFilters
{
	const OP_EQUALS = '='; // All data types
	const OP_NOT_EQUALS = '!='; // All data types
	const OP_GREATER = '>'; // Integer or Date
	const OP_LESS = '<'; // Integer or Date
	const OP_GREATER_EQUALS = '>='; // Integer or Date
	const OP_LESS_EQUALS = '<='; // Integer or Date
	const OP_CONTAINS = '~'; // String
	const OP_NOT_CONTAINS = '!~'; // String

	const COMP_OR = 'OR';
	const COMP_AND = 'AND';

	private $_comparison;

	private $_filters = [];

	/**
	 * @param string $comparison
	 */
	public function __construct(string $comparison = self::COMP_AND)
	{
		$this->_comparison = $comparison;
	}

	/**
	 * @param mixed $comparison
	 * @return SearchFilters
	 */
	public function setComparison($comparison): SearchFilters
	{
		$this->_comparison = $comparison;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getComparison()
	{
		return $this->_comparison;
	}

	/**
	 * @return array
	 */
	public function getFilters(): array
	{
		return $this->_filters;
	}

	public function addFilter(string $field, $value, string $operator = self::OP_EQUALS, string $alias = NULL): SearchFilters
	{
		$this->_filters[$alias ?? $field] = [
			'field'    => $field,
			'operator' => $operator,
			'value'    => $value
		];
		return $this;
	}

	public function removeFilter(string $field): SearchFilters
	{
		unset($this->_filters[$field]);
		return $this;
	}

	public function clear(): SearchFilters
	{
		$this->_filters = [];
		return $this;
	}

	public function makeBodyParams(): array
	{
		if (empty($this->_filters)) {
			return [];
		} elseif (sizeof($this->_filters) > 1) {
			return [
				'comparison' => $this->_comparison,
				'filter' => array_values($this->_filters),
			];
		} else {
			return [
				'filter' => array_values($this->_filters),
			];
		}
	}
}
