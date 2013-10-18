<?php
class DataRankBase{
	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE rankBase");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$rankId = $data[0];
			$rankName = $data[1];
			$monsterLevel = $data[2];
			$hp = $data[3];
			$attack = $data[4];
			$speed = $data[5];
			$restore = $data[6];

			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO rankBase (
			`rankId`,`rankName`,`monsterLevel`,`hp`,`attack`,`speed`,`restore`,`createTime`
			)VALUES (
			'$rankId','$rankName','$monsterLevel','$hp','$attack','$speed','$restore','$createTime'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
