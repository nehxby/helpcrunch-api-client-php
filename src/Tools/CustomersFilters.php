<?php

namespace Helpcrunch\PublicApi\Tools;

class CustomersFilters extends SearchFilters
{
	public const string FIELD_ID = 'customers.id';
	public const string FIELD_NAME = 'customers.name';
	public const string FIELD_EMAIL = 'customers.email';
	public const string FIELD_COMPANY = 'customers.company';
	public const string FIELD_PHONE = 'customers.phone';
	public const string FIELD_COUNTRY_CODE = 'customers.countryCode';
	public const string FIELD_CITY = 'customers.city';
	public const string FIELD_REGION_CODE = 'customers.regionCode';
	public const string FIELD_TAGS_DATA = 'customers.tagsData';
	public const string FIELD_LAST_SEEN = 'customers.lastSeen';
	public const string FIELD_USER_ID = 'customers.userId';


	public function addId(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_ID, $value, $operator);
	}

	public function addName(string $value, string $operator = self::OP_CONTAINS): self
	{
		return $this->addFilter(self::FIELD_NAME, $value, $operator);
	}

	public function addEmail(string $value, string $operator = self::OP_CONTAINS): self
	{
		return $this->addFilter(self::FIELD_EMAIL, $value, $operator);
	}

	public function addCompany(string $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_COMPANY, $value, $operator);
	}

	public function addPhone(string $value, string $operator = self::OP_CONTAINS): self
	{
		return $this->addFilter(self::FIELD_PHONE, $value, $operator);
	}

	public function addCountryCode(string $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_COUNTRY_CODE, $value, $operator);
	}

	public function addCity(string $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_CITY, $value, $operator);
	}

	public function addRegionCode(string $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_REGION_CODE, $value, $operator);
	}

	/**
	 * @param array $value Tags assigned to the customer, e.g. [{"name": "Lead"}, {"name": "Paid"}]
	 * @param string $operator
	 * @return CustomersFilters
	 */
	public function addTagsData(array $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_TAGS_DATA, $value, $operator);
	}

	public function addLastSeen(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_LAST_SEEN, $value, $operator);
	}

	public function addUserId($value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_USER_ID, $value, $operator);
	}

}
