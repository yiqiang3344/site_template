<?php

class DataQuest{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		
		$command = Yii::app()->db->createCommand("TRUNCATE quest");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$questTitle = $data[1];
			$rank = $data[2];
			$rankKey = $data[7];
			$questCategory = $data[11];
			$deleteFlag = $data[12];
			
			if(!$data[9]){
				$questCondition = '';
			}else{
				$command = Yii::app()->db->createCommand('select * from quest where questTitle =:questTitle');
				$command->bindValue(':questTitle',$data[9]);
				$record = $command->queryRow();
				$id = $record['questId'];
				$questCondition = $id;
			}
			$maxFailTimes = $data[10];
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO quest (
			`questTitle`,`questCategory`,`questCondition`,`rank`,`rankKey`,`maxFailTimes`,`createTime`,`deleteFlag`
			)VALUES (
			'$questTitle',$questCategory,'$questCondition',$rank,$rankKey,$maxFailTimes,$createTime,$deleteFlag
			)");
			$command->execute();
		}
		fclose($handle);
	}

}
