<?php

class DataMonsterBasic{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$command = Yii::app()->db->createCommand("TRUNCATE monsterBasic");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			//var_dump($data);exit;
			if($data[1]==false){
				break;
			}
			$color 			= intval($data[4]);
			$firstMeet		= intval($data[5]);
			$lasttMeet		= intval($data[6]);
			$templeteLevel 	= $data[8];
			$monsterName 	= $data[1];
			$hp 			= $data[9];
			$attack 		= $data[10];
			$speed			= $data[11];
			$restore		= $data[12];
			
			$cri			= $data[13];
			$ai = explode('_',$data[14]);
			
			$monsterAI		= intval($ai[1]);
			$turn1			= $data[15];
			$turn2			= $data[16];
			$turn3			= $data[17];
			$turn4			= $data[18];
			$turn5			= $data[19];
			$turn6			= $data[20];
			$turn7			= $data[21];
									
			$hitNum			= $data[22];
			
			$think = '';
			
			$id = 0;
			if($data[23] && $data[24]){
				$param = explode('_',$data[23]);
				$id = $param[1];
				$think[] = array('id'=>$id,'rate'=>$data[24]);
			}
			if($data[25] && $data[26]){
				$param = explode('_',$data[25]);
				$id = $param[1];
				$think[] = array('id'=>$id,'rate'=>$data[26]);
			}
			if($data[27] && $data[28]){
				$param = explode('_',$data[27]);
				$id = $param[1];
				$think[] = array('id'=>$id,'rate'=>$data[28]);
			}
			if($data[29] && $data[30]){
				$param = explode('_',$data[29]);
				$id = $param[1];
				$think[] = array('id'=>$id,'rate'=>$data[30]);
			}
			if($think){
				$think = serialize($think);
			}
			$factor = intval($data[31]);
			$id = $type = $rankRate = $rate =  0;
			$unionDrop = '';
			if($data[32] && $data[33]){
				$preFix = substr($data[32],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[32]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[32]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[32]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[32]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[32]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 100;
				$rate = $data[33];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			if($data[34] && $data[35]){
				$preFix = substr($data[34],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[34]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[34]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[34]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[34]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[34]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 100;
				$rate = $data[35];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			if($data[36] && $data[37]){
				$preFix = substr($data[36],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[36]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[36]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[36]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[36]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[36]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 100;
				$rate = $data[37];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			//70%
			if($data[38] && $data[39]){
				$preFix = substr($data[37],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[38]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[38]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[38]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[38]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[38]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 70;
				$rate = $data[39];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			//50
			if($data[40] && $data[41]){
				$preFix = substr($data[40],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[40]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[40]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[40]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[40]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[40]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 50;
				$rate = $data[41];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			//30
			if($data[42] && $data[43]){
				$preFix = substr($data[41],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[42]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[42]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[42]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[42]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[42]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 30;
				$rate = $data[43];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			//20
			if($data[44] && $data[45]){
				$preFix = substr($data[44],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[44]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[44]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[44]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[44]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[44]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 20;
				$rate = $data[45];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			//10
			if($data[46] && $data[47]){
				$preFix = substr($data[45],0,5);
				//0 equip,1 uitem,2 citem,3 eitem,4 sitem
				switch ($preFix){
					case 'Equip':
						$command = Yii::app()->db->createCommand('select * from equipmentBase where baseName=:baseName');
						$command->bindValue(':baseName',$data[46]);
						$record = $command->queryRow();
						$id = $record['equipmentBaseId'];
						$type = 0;
						break;
					case 'U_Ite':
						$param = explode('_',$data[46]);
						$id = intval($param[2]);
						$type = 1;
						break;
					case 'C_Ite':
						$param = explode('_',$data[46]);
						$id = intval($param[2]);
						$type = 2;
						break;
					case 'E_Ite':
						$param = explode('_',$data[46]);
						$id = intval($param[2]);
						$type = 3;
						break;
					default:
						$param = explode('_',$data[46]);
						$id = intval($param[2]);
						$type = 4;
						break;
				}
				$rankRate = 10;
				$rate = $data[47];
				$unionDrop[] = array('id'=>$id,'type'=>$type,'ranking'=>$rankRate,'rate'=>$rate);
			}
			if($unionDrop){
				$unionDrop = serialize($unionDrop);
			}
			$createTime = time();

			$command = Yii::app()->db->createCommand("INSERT INTO monsterBasic (
			`monsterName`,`color`,`firstMeet`,`lastMeet`,`templeteLevel`,`hp`,`attack`,`speed`,`restore`,`hitNum`,`monsterAI`,`cri`,
			`turn1`,`turn2`,`turn3`,`turn4`,`turn5`,`turn6`,`turn7`,
			`think`,`factor`,`unionDrop`,`createTime`
			)VALUES (
			'$monsterName',$color,$firstMeet,$lasttMeet, $templeteLevel, $hp, $attack, $speed, $restore, $hitNum ,$monsterAI, $cri,
			$turn1,$turn2,$turn3,$turn4,$turn5,$turn6,$turn7,
			'$think','$factor','$unionDrop', $createTime
			)");
			$command->execute();
		}
		fclose($handle);
	}

}
