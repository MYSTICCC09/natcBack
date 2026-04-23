<?php

class m150922_103421_alterTables extends YdDbMigration
{
	public function safeUp() {

		// Run single query: update the sentence table to include a langid

		// Import sql file:
		$this->import('m150922_103421_alterTables.sql');
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