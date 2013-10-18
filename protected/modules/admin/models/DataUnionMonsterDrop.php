<?php

class DataUnionMonsterDrop{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE unionMonsterDrop");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[0]==false){
				break;
			}
			$goldReward = $data[1];
			$reputationReward = $data[2];
			$expReward = $data[3];
			
			$dropList = array(
				array('itemName'=>$data[4],'rate'=>$data[5],'ranking'=>100),
				array('itemName'=>$data[6],'rate'=>$data[7],'ranking'=>100),
				array('itemName'=>$data[8],'rate'=>$data[9],'ranking'=>100),
				array('itemName'=>$data[10],'rate'=>$data[11],'ranking'=>70),
				array('itemName'=>$data[12],'rate'=>$data[13],'ranking'=>50),
				array('itemName'=>$data[14],'rate'=>$data[15],'ranking'=>25),
				array('itemName'=>$data[16],'rate'=>$data[17],'ranking'=>10),
				array('itemName'=>$data[18],'rate'=>$data[19],'ranking'=>5),
			);
			$unionDrop = '';
			foreach ($dropList as $item){
				if($item['itemName']&&$item['rate']){
					$preFix = substr($item['itemName'],0,5);
					//0 equip,1 uitem,2 citem,3 eitem,4 sitem
					switch ($preFix){
						case '<E>':
							$id = $item['itemName'];
							$type = 0;
							break;
						case 'Equip':
							$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
							$command->bindValue(':baseName',$item['itemName']);
							$record = $command->queryRow();
							$id = $record['equipmentBaseId'];
							$type = 0;
							break;
						case 'U_Ite':
							$param = explode('_',$item['itemName']);
							$id = intval($param[2]);
							$type = 1;
							break;
						case 'C_Ite':
							$param = explode('_',$item['itemName']);
							$id = intval($param[2]);
							$type = 2;
							break;
						case 'E_Ite':
							$param = explode('_',$item['itemName']);
							$id = intval($param[2]);
							$type = 3;
							break;
						default:
							$param = explode('_',$item['itemName']);
							$id = intval($param[2]);
							$type = 4;
							break;
					}
					$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$item['ranking'],'rate'=>$item['rate']);
				}
			}
			$unionDrop = is_array($unionDrop)?serialize($unionDrop):'';
			//equipColor
			$color = serialize(array(
				array('id'=>1,'rate'=>$data[20]),
				array('id'=>2,'rate'=>$data[21]),
				array('id'=>3,'rate'=>$data[22]),
				array('id'=>4,'rate'=>$data[23]),
				array('id'=>5,'rate'=>$data[24]),
			));
			
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO unionMonsterDrop (
			`goldReward`,`reputationReward`,`expReward`,`dropList`
			,`color`,`createTime`
			)VALUES (
			'$goldReward','$reputationReward','$expReward','$unionDrop'
			,'$color','$createTime'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
