<?php

class m150923_005524_createFollowTable extends YdDbMigration
{
	public function safeUp() {

		// Run single query: update the sentence table to include a langid

		// Import sql file:
		$this->import('m150923_005524_createFollowTable.sql');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}