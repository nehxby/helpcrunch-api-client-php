<?php

namespace Helpcrunch\PublicApi\Tools;

class ChatsFilters extends SearchFilters
{
	/*
	 * chat fields
	 */
	public const string FIELD_ASSIGNEE = 'chats.assignee';
	public const string FIELD_AGENTS = 'chats.agents';
	public const string FIELD_CREATED_AT = 'chats.createdAt';
	public const string FIELD_UPDATED_AT = 'chats.updatedAt';
	public const string FIELD_DEPARTMENT = 'chats.department';
	public const string FIELD_STATUS = 'chats.status';
	public const string FIELD_CLOSED_AT = 'chats.closedAt';
	public const string FIELD_RATING = 'chats.rating';

	/*
	 * customer fields
	 */
	public const string FIELD_CUSTOMER = 'chats.customer';
	public const string FIELD_EMAIL = 'chats.customer.email';
	public const string FIELD_TAGS_DATA = 'chats.customer.tagsData';
	public const string FIELD_USER_ID = 'chats.customer.userId';


	/*
	 * status values
	 */
	public const string STATUS_NEW = 'new';
	public const string STATUS_OPENED = 'opened';
	public const string STATUS_PENDING = 'pending';
	public const string STATUS_ON_HOLD = 'on-hold';
	public const string STATUS_CLOSED = 'closed';
	public const string STATUS_NO_COMMUNICATION = 'no communication';

	/*
	 * rating values
	 */
	public const string RATING_GREAT = 'great';
	public const string RATING_AVE = 'average';
	public const string RATING_POOR = 'poor';


	public function addAssignee(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_ASSIGNEE, $value, $operator);
	}

	public function addAgents(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_AGENTS, $value, $operator);
	}

	public function addCreatedAt(int $value, string $operator = self::OP_GREATER_EQUALS): self
	{
		return $this->addFilter(self::FIELD_CREATED_AT, $value, $operator);
	}

	public function addUpdatedAt(int $value, string $operator = self::OP_GREATER_EQUALS): self
	{
		return $this->addFilter(self::FIELD_UPDATED_AT, $value, $operator);
	}

	public function addDepartment(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_DEPARTMENT, $value, $operator);
	}

	public function addStatus(string $value = self::STATUS_OPENED, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_STATUS, $value, $operator);
	}

	public function addClosedAt(int $value, string $operator = self::OP_LESS_EQUALS): self
	{
		return $this->addFilter(self::FIELD_CLOSED_AT, $value, $operator);
	}

	public function addRating(string $value = self::RATING_POOR, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_RATING, $value, $operator);
	}

	// ============== CUSTOMER FILTERS

	public function addCustomer(int $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_CUSTOMER, $value, $operator);
	}

	public function addEmail(string $value, string $operator = self::OP_CONTAINS): self
	{
		return $this->addFilter(self::FIELD_EMAIL, $value, $operator);
	}

	/**
	 * @param array $value Tags assigned to the chat, e.g. [{"name": "Lead"}, {"name": "Paid"}]
	 * @param string $operator
	 * @return ChatsFilters
	 */
	public function addTagsData(array $value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_TAGS_DATA, $value, $operator);
	}

	public function addUserId($value, string $operator = self::OP_EQUALS): self
	{
		return $this->addFilter(self::FIELD_USER_ID, $value, $operator);
	}
}
