<?php

namespace Helpcrunch\PublicApi\Tools;

abstract class SearchFilters
{
	public const string OP_EQUALS = '='; // All data types
	public const string OP_NOT_EQUALS = '!='; // All data types
	public const string OP_GREATER = '>'; // Integer or Date
	public const string OP_LESS = '<'; // Integer or Date
	public const string OP_GREATER_EQUALS = '>='; // Integer or Date
	public const string OP_LESS_EQUALS = '<='; // Integer or Date
	public const string OP_CONTAINS = '~'; // String
	public const string OP_NOT_CONTAINS = '!~'; // String

	public const string COMP_OR = 'OR';
	public const string COMP_AND = 'AND';

	private string $_comparison;

	private array $_filters = [];

	/**
	 * @param string $comparison
	 */
	public function __construct(string $comparison = self::COMP_AND)
	{
		$this->_comparison = $comparison;
	}

	public function setComparison(string $comparison): SearchFilters
	{
		$this->_comparison = $comparison;
		return $this;
	}

	public function getComparison(): string
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

	public function addFilter(string $field, $value, string $operator = self::OP_EQUALS, ?string $alias = NULL): static
	{
		$this->_filters[$alias ?? $field] = [
			'field'    => $field,
			'operator' => $operator,
			'value'    => $value
		];
		return $this;
	}

	public function removeFilter(string $field): static
	{
		unset($this->_filters[$field]);
		return $this;
	}

	public function clear(): static
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
