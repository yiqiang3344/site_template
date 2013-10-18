<?php

class DataEquipmentParam {
	static private $_tableName = 'equipmentBase';

	static public function run($csvFileName){
		self::deleteData();
		$tableName = self::$_tableName;
		$row = 0;
		$handle = fopen($csvFileName,"r");

		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");

		while ($data = fgetcsv($handle, 1000, ",")) {
			if ($data[1] == '') {
				continue;
			}
			if ($data[0] !== '//') {
				$row++;
				$equipmentBaseId = $row;
				$baseName = $data[1];
				$name = $data[2];
				$category = $data[4];
				$rarity = $data[5];
				$slot = $data[6];
				$characterType = $data[7];
				$type = $data[8];
				$maxLv = $data[9];
				$hpMax = $data[10];
				$hpMaxPlus = $data[11];
				$attack = $data[12];
				$attactPlus = $data[13];
				$speed = $data[14];
				$speedPlus = $data[15];
				$indirectAttack = $data[16];
				$indirectAttackPlus = $data[17];
				$assistAttack = $data[18];
				$assistAttackPlus = $data[19];
				$assistDefend = $data[20];
				$assistDefendPlus = $data[21];
				$restore = $data[22];
				$restorePlus = $data[23];
				$cri = $data[24];
				$criPlus = $data[25];
				$hitNum = $data[26];
				$price = str_replace(',', '', $data[27]);
				$characterLv = $data[28];
				$job_01 = $data[29];
				$job_02 = $data[30];
				$job_03 = $data[31];
				$job_04 = $data[32];
				$job_05 = $data[33];
				$job_06 = $data[34];
				$job_07 = $data[35];
				$job_08 = $data[36];
				$job_09 = $data[37];
				$job_10 = $data[38];
				$job_11 = $data[39];
				$job_12 = $data[40];
				$job_13 = $data[41];
				$job_14 = $data[42];
				$job_15 = $data[43];
				$job_16 = $data[44];
				$job_17 = $data[45];
				$createTime = time();
				if ($baseName) {			
					$sql = "insert into $tableName values ($equipmentBaseId, '".$baseName."', '', $category, $rarity, $slot, $type, $maxLv, $characterType, $hpMax, $hpMaxPlus, $attack, $attactPlus, $speed, $speedPlus, $indirectAttack, $indirectAttackPlus, $assistAttack, $assistAttackPlus, $assistDefend, $assistDefendPlus, $restore, $restorePlus, $cri, $criPlus, $hitNum, $price, $characterLv, $job_01, $job_02, $job_03, $job_04, $job_05, $job_06, $job_07, $job_08, $job_09, $job_10, $job_11, $job_12, $job_13, $job_14, $job_15, $job_16, $job_17, $createTime, 0)";
					$command = Yii::app()->db->createCommand($sql);
					$command->execute();
				}
			}
		}
		fclose($handle);
		self::deleteSpirit();
	}

	static private function deleteData() {
		$tableName = self::$_tableName;
	    $sql = "delete from $tableName";
		$command = Yii::app()->db->createCommand($sql);
		$command->execute();
	}

	static private function deleteSpirit() {
		$tableName = self::$_tableName;
	    $command = Yii::app()->db->createCommand("delete from $tableName where characterType = 1");
		$command->execute();
	}
}
