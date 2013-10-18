<?php

class DataUnionDrop{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE unionPeriodDrop");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[0]==false){
				break;
			}
			$monsterLevel = $data[1];			
			$dropList = array(
				array('itemName'=>$data[2],'rate'=>$data[3],'ranking'=>100),
				array('itemName'=>$data[4],'rate'=>$data[5],'ranking'=>100),
				array('itemName'=>$data[6],'rate'=>$data[7],'ranking'=>100),
				array('itemName'=>$data[8],'rate'=>$data[9],'ranking'=>70),
				array('itemName'=>$data[10],'rate'=>$data[11],'ranking'=>25),
				array('itemName'=>$data[12],'rate'=>$data[13],'ranking'=>10),
				array('itemName'=>$data[14],'rate'=>$data[15],'ranking'=>5),
				array('itemName'=>$data[16],'rate'=>$data[17],'ranking'=>1),
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
				array('id'=>1,'rate'=>intval($data[18])),
				array('id'=>2,'rate'=>intval($data[19])),
				array('id'=>3,'rate'=>intval($data[20])),
				array('id'=>4,'rate'=>intval($data[21])),
				array('id'=>5,'rate'=>intval($data[22])),
			));
			
			$createTime = time();
			$command = Yii::app()->db->createCommand("INSERT INTO unionPeriodDrop (
			`monsterLevel`,`dropList`,`color`,`createTime`
			)VALUES (
			'$monsterLevel','$unionDrop','$color','$createTime'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
