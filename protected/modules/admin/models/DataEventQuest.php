<?php

class DataEventQuest{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		
		//$command = Yii::app()->db->createCommand("TRUNCATE quest");
		//$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[0]==false){
				break;
			}
			$questId = $data[0];
			$questTitle = $data[1];
			$rank = 0;
			$rankKey = 0;
			$questCategory = $data[10];
			$deleteFlag = $data[11];
			$creditReward = isset($data[12]) ? $data[12] : 0;
			$accumulateNum = isset($data[13]) ? $data[13] : 0;
			
			if(!$data[8]){
				$questCondition = '';
			}else{
				$command = Yii::app()->db->createCommand('select * from quest where questTitle =:questTitle');
				$command->bindValue(':questTitle',$data[9]);
				$record = $command->queryRow();
				$id = $record['questId'];
				$questCondition = $id;
			}
			$maxFailTimes = $data[9];
			$createTime = time();
            $sql = "INSERT INTO quest (
			`questId`,`questTitle`,`questCategory`,`questCondition`,`rank`,`rankKey`,`maxFailTimes`,`createTime`,`deleteFlag`,`accumulateNum`,`creditReward`
			)VALUES (
			$questId,'$questTitle',$questCategory,'$questCondition',$rank,$rankKey,$maxFailTimes,$createTime,$deleteFlag,$accumulateNum,$creditReward
			)";
            //echo $sql;
            //echo "<hr>";
			$command = Yii::app()->db->createCommand($sql);
			$command->execute();
		}
		fclose($handle);
	}

}
