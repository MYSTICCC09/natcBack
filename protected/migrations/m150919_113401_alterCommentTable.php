<?php

class m150919_113401_alterCommentTable extends YdDbMigration
{
	public function safeUp() {

		// Run single query: update the sentence table to include a langid

		// Import sql file:
		$this->import('m150919_113401_alterCommentTable.sql');
	}
}