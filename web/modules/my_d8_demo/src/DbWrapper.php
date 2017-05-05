<?php

namespace Drupal\my_d8_demo;

use Drupal\Core\Database\Connection;

class DbWrapper {
	private $connection;
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
	public function getData() {
		$return = $this->connection->select ( 'user_data', 'ud' )->fields ( 'ud', array (
				'fname',
				'lname'
		) )->range ( 0, 1 )->execute ()->fetchAssoc ();
		return $return;
	}
	public function setData($fname, $lname) {
		$this->connection->insert ( 'user_data' )->fields ( [
				'fname' => $fname,
				'lname' => $lname
		] )->execute ();
	}
}