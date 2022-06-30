<?php

namespace Helpcrunch\PublicApi\Tools;

class ChatsFilters extends SearchFilters
{
	/*
	 * chat fields
	 */
	const FIELD_ASSIGNEE = 'chats.assignee';
	const FIELD_AGENTS = 'chats.agents';
	const FIELD_CREATED_AT = 'chats.createdAt';
	const FIELD_UPDATED_AT = 'chats.updatedAt';
	const FIELD_DEPARTMENT = 'chats.department';
	const FIELD_STATUS = 'chats.status';
	const FIELD_CLOSED_AT = 'chats.closedAt';
	const FIELD_RATING = 'chats.rating';

	/*
	 * customer fields
	 */
	const FIELD_CUSTOMER = 'chats.customer';
	const FIELD_EMAIL = 'chats.customer.email';
	const FIELD_TAGS_DATA = 'chats.customer.tagsData';
	const FIELD_USER_ID = 'chats.customer.userId';


	/*
	 * status values
	 */
	const STATUS_NEW = 'new';
	const STATUS_OPENED = 'opened';
	const STATUS_PENDING = 'pending';
	const STATUS_ON_HOLD = 'on-hold';
	const STATUS_CLOSED = 'closed';
	const STATUS_NO_COMMUNICATION = 'no communication';

	/*
	 * rating values
	 */
	const RATING_GREAT = 'great';
	const RATING_AVE = 'average';
	const RATING_POOR = 'poor';


	public function addAssignee(int $value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_ASSIGNEE, $value, $operator);
	}

	public function addAgents(int $value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_AGENTS, $value, $operator);
	}

	public function addCreatedAt(int $value, string $operator = self::OP_GREATER_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_CREATED_AT, $value, $operator);
	}

	public function addUpdatedAt(int $value, string $operator = self::OP_GREATER_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_UPDATED_AT, $value, $operator);
	}

	public function addDepartment(int $value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_DEPARTMENT, $value, $operator);
	}

	public function addStatus(string $value = self::STATUS_OPENED, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_STATUS, $value, $operator);
	}

	public function addClosedAt(int $value, string $operator = self::OP_LESS_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_CLOSED_AT, $value, $operator);
	}

	public function addRating(string $value = self::RATING_POOR, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_RATING, $value, $operator);
	}

	// ============== CUSTOMER FILTERS

	public function addCustomer(int $value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_CUSTOMER, $value, $operator);
	}

	public function addEmail(string $value, string $operator = self::OP_CONTAINS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_EMAIL, $value, $operator);
	}

	/**
	 * @param array $value Tags assigned to the chat, e.g. [{"name": "Lead"}, {"name": "Paid"}]
	 * @param string $operator
	 * @return ChatsFilters
	 */
	public function addTagsData(array $value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_TAGS_DATA, $value, $operator);
	}

	public function addUserId($value, string $operator = self::OP_EQUALS): ChatsFilters
	{
		return $this->addFilter(self::FIELD_USER_ID, $value, $operator);
	}
}
