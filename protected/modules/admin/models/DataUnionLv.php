<?php

class DataUnionLv{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE unionLv");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[0]==false){
				break;
			}
			$period = $data[0];
			$maxLevel = $data[1];
			$hpFactor = $data[2];
			$attackFactor = $data[3];
			$speedFactor = $data[4];
			$restoreFactor = $data[5];
						
			$armyParam = explode('_',$data['6']);
			$armyId = intval($armyParam[1]);
			
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO unionLv (
			`period`,`maxLevel`,`hpFactor`,`attackFactor`,`speedFactor`,`restoreFactor`,`armyId`,`createTime`
			)VALUES (
			'$period','$maxLevel','$hpFactor','$attackFactor','$speedFactor','$restoreFactor','$armyId','$createTime'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
