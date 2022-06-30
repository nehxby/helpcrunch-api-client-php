<?php

use Helpcrunch\PublicApi\Customers;
use Helpcrunch\PublicApi\Tools\Client;
use Helpcrunch\PublicApi\Tools\CustomersFilters;

$hc = new Client('domain', 'key');
$customers = $hc->getCustomers();

// ============================================= get single customer
$customerId = 5;
$r = $customers->get($customerId);

// ============================================= get all customers
$r = $customers->list();
$r = $customers->list(20, 20, Customers::SORT_FIRST_SEEN);

// ============================================= search customers
$filter = (new CustomersFilters(CustomersFilters::COMP_OR))
	->addEmail('gmail')
	->addLastSeen(strtotime('yesterday'), CustomersFilters::OP_LESS_EQUALS);

$r = $customers->search($filter, 20, 20, Customers::SORT_FIRST_SEEN, 'desc');

// ============================================= search customers by date range
$filter->clear()
	->addLastSeen(strtotime('2022-02-24'), CustomersFilters::OP_GREATER_EQUALS) // date since
	->addFilter(CustomersFilters::FIELD_LAST_SEEN, strtotime('now'), CustomersFilters::OP_LESS_EQUALS, 'date_till')
	->setComparison(CustomersFilters::COMP_AND);

$r = $customers->search($filter, 20, 20, Customers::SORT_FIRST_SEEN, 'desc');
