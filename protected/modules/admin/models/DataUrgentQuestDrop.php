<?php

class DataUrgentQuestDrop{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE urgentQuestDrop");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$urgentMonsterTimes = $data[0];
			$monsterBasicId		= $data[1];
			$goldReward			= $data[2];
			$reputationReward	= $data[3];
			$equipmentLevel		= $data[4];
			$dropItems = array();
			$items = array(
				array($data[5],$data[6]),
				array($data[7],$data[8]),
				array($data[9],$data[10]),
				array($data[11],$data[12]),
				array($data[13],$data[14]),
				array($data[15],$data[16]),
				array($data[17],$data[18]),
				array($data[19],$data[20]),
				);
			foreach ($items as $item){
				if($item[0] && $item[1]){
					$itemName = $item[0];
					$itemRate = $item[1];
					$itemParam = explode('_',$itemName);
					switch($itemParam[0]){
						case 'Equip':$type = 0;break;
						case 'U':$type = 1;break;
						case 'C':$type = 2;break;
						case 'E':$type = 3;break;
						case 'S':$type = 4;break;
						case '<E>':$type = 0;break;
						default:$type=0;
					}
					if($type){
						$id = intval($itemParam[2]);
					}else{
						if($itemName == '<E>'){
							$id = '<E>';
						}else{
							$command4 = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
							$command4->bindValue(':baseName',$itemName);
							$record = $command4->queryRow();
							$id = $record['equipmentBaseId'];
						}
					}
					$dropItems[]=array('id'=>$id,'t'=>$type,'rate'=>$itemRate);
				}
			}
			$dropItems = serialize($dropItems);
			//equipColor
			$color = serialize(array(
				array('id'=>1,'rate'=>$data[21]),
				array('id'=>2,'rate'=>$data[22]),
				array('id'=>3,'rate'=>$data[23]),
				array('id'=>4,'rate'=>$data[24]),
				array('id'=>5,'rate'=>$data[25]),
			));
			$miniRankId = $data[27];
			
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO urgentQuestDrop (
			`urgentMonsterTimes`,`monsterBasicId`,`goldReward`,`reputationReward`,`equipmentLevel`,`dropItemList`,`color`,`createTime`,`miniRankId`
			)VALUES (
			'$urgentMonsterTimes','$monsterBasicId','$goldReward','$reputationReward','$equipmentLevel','$dropItems','$color','$createTime','$miniRankId'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
