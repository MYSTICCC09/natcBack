<?php

class m150915_170349_initialDatabase extends YdDbMigration
{
	public function safeUp() {

		// Run single query: update the sentence table to include a langid

		// Import sql file:
		$this->import('m150915_170349_initialDatabase.sql');
	}
}