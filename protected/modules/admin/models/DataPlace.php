<?php

class DataPlace{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE place");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$placeId = $data[0];
			$placeName = $data[1];
			switch ($data[2]){
				case '村':$type = 0;break;
				case '山':$type = 1;break;
				case '洞窟':$type = 2;break;
				case '森':$type = 3;break;
				case '川':$type = 4;break;
				case '湖':$type = 5;break;
				case '高原':$type = 6;break;
				case '町':$type = 7;break;
				case '神殿':$type = 8;break;
				case '魔城':$type = 9;break;
				default:$type=0;
			}
			$areaId = $data[4];
			$bg = $data[6];
			
			$command = Yii::app()->db->createCommand("INSERT INTO place (
			`placeId`,`placeName`,`type`,`areaId`,`bg`
			)VALUES (
			'$placeId','$placeName','$type','$areaId','$bg'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
