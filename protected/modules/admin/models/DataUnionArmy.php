<?php

class DataUnionArmy{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE unionArmy");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$name = $data[1];
			//4-15monster
			$monsters = array(
				array('id'=>$data[4],'rate'=>$data[5]),
				array('id'=>$data[7],'rate'=>$data[8]),
				array('id'=>$data[10],'rate'=>$data[11]),
				array('id'=>$data[13],'rate'=>$data[14])
			);
			$monsterList = serialize($monsters);
			$placeId = $data[16];
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO unionArmy (
			`name`,`monsterList`,`createTime`,`placeId`
			)VALUES (
			'$name','$monsterList','$createTime','$placeId'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
