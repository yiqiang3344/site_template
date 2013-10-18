<?php

class DataMonsterAI{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");

		$command = Yii::app()->db->createCommand("TRUNCATE monsterAI");
		$command->execute();

		while ($data = fgetcsv($handle, 1000, ",")) {
			$row++;
			$monsterAI = $row;
			if(!preg_match('/AI/', $data[1])){
				break;
			}
			$turn1 = intval($data[4]);
			$turn2 = intval($data[5]);
			$turn3 = intval($data[6]);
			$turn4 = intval($data[7]);
			$turn5 = intval($data[8]);
			$turn6 = intval($data[9]);
			$turn7 = intval($data[10]);
			$createTime = time();

			$command = Yii::app()->db->createCommand("INSERT INTO monsterAI (id, turn1, turn2, turn3, turn4, turn5, turn6, turn7, createTime) VALUES ($monsterAI, $turn1, $turn2, $turn3, $turn4, $turn5, $turn6, $turn7, $createTime)");
			$command->execute();
		}
		fclose($handle);
	}

}
