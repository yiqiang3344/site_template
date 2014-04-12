<?php

class m140412_043302_addTableSystemSet extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
			DROP TABLE IF EXISTS systemSet;
			CREATE TABLE systemSet (
			    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
			    `logo` varchar(256) NOT NULL COMMENT 'logo url',
			    `updateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '',
			    `recordTime` int(10) UNSIGNED NOT NULL COMMENT '',
			    PRIMARY KEY (`id`)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='' AUTO_INCREMENT=1 ;
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m140412_043302_addTableSystemSet does not support migration down.\n";
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