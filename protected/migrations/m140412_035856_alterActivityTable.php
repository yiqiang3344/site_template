<?php

class m140412_035856_alterActivityTable extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
			ALTER TABLE  `activity` ADD  `isEnd` TINYINT( 1 ) UNSIGNED NOT NULL AFTER  `content` ;
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m140412_035856_alterActivityTable does not support migration down.\n";
		return false;
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