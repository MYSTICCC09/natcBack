<?php

class m150504_154455_createAuthTables extends YdDbMigration
{
    public function safeUp() {

        // Run single query: update the sentence table to include a langid

        // Import sql file:
        $this->import('m150504_154455_createAuthTables.sql');
    }
}