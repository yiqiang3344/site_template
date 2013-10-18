<?php
class DataQuestRankDrop{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		
		$command = Yii::app()->db->createCommand("TRUNCATE questRankDrop");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if($data[1]==false){
				break;
			}
			$rank = $data[1];
			$dropCharacterRate = $data[3];
			//4-20dropCharacter
			$dropCharacter = array();
			if($data[4] >0){
				$dropCharacter[]=array('id'=>1,'rate'=>$data[4]);
			}
			if($data[5] >0){
				$dropCharacter[]=array('id'=>2,'rate'=>$data[5]);
			}
			if($data[6] >0){
				$dropCharacter[]=array('id'=>3,'rate'=>$data[6]);
			}
			if($data[7] >0){
				$dropCharacter[]=array('id'=>4,'rate'=>$data[7]);
			}
			if($data[8] >0){
				$dropCharacter[]=array('id'=>5,'rate'=>$data[8]);
			}
			if($data[9] >0){
				$dropCharacter[]=array('id'=>6,'rate'=>$data[9]);
			}
			if($data[10] >0){
				$dropCharacter[]=array('id'=>7,'rate'=>$data[10]);
			}
			if($data[11] >0){
				$dropCharacter[]=array('id'=>8,'rate'=>$data[11]);
			}
			if($data[12] >0){
				$dropCharacter[]=array('id'=>9,'rate'=>$data[12]);
			}
			if($data[13] >0){
				$dropCharacter[]=array('id'=>10,'rate'=>$data[13]);
			}
			if($data[14] >0){
				$dropCharacter[]=array('id'=>11,'rate'=>$data[14]);
			}
			if($data[15] >0){
				$dropCharacter[]=array('id'=>12,'rate'=>$data[15]);
			}
			if($data[16] >0){
				$dropCharacter[]=array('id'=>13,'rate'=>$data[16]);
			}
			if($data[17] >0){
				$dropCharacter[]=array('id'=>14,'rate'=>$data[17]);
			}
			if($data[18] >0){
				$dropCharacter[]=array('id'=>15,'rate'=>$data[18]);
			}
			if($data[19] >0){
				$dropCharacter[]=array('id'=>16,'rate'=>$data[19]);
			}
			if($data[20] >0){
				$dropCharacter[]=array('id'=>17,'rate'=>$data[20]);
			}
//追加
			if($data[21] >0){
				$dropCharacter[]=array('id'=>18,'rate'=>$data[21]);
			}
			if($data[22] >0){
				$dropCharacter[]=array('id'=>19,'rate'=>$data[22]);
			}
			if($data[23] >0){
				$dropCharacter[]=array('id'=>20,'rate'=>$data[23]);
			}
			if($data[24] >0){
				$dropCharacter[]=array('id'=>21,'rate'=>$data[24]);
			}
			if($data[25] >0){
				$dropCharacter[]=array('id'=>22,'rate'=>$data[25]);
			}
			if($data[26] >0){
				$dropCharacter[]=array('id'=>23,'rate'=>$data[26]);
			}
			if($data[27] >0){
				$dropCharacter[]=array('id'=>24,'rate'=>$data[27]);
			}
			if($data[28] >0){
				$dropCharacter[]=array('id'=>25,'rate'=>$data[28]);
			}
			if($data[29] >0){
				$dropCharacter[]=array('id'=>26,'rate'=>$data[29]);
			}
			if($data[30] >0){
				$dropCharacter[]=array('id'=>27,'rate'=>$data[30]);
			}
			if($data[31] >0){
				$dropCharacter[]=array('id'=>28,'rate'=>$data[31]);
			}
			if($data[32] >0){
				$dropCharacter[]=array('id'=>29,'rate'=>$data[32]);
			}
			if($data[33] >0){
				$dropCharacter[]=array('id'=>30,'rate'=>$data[33]);
			}
			if($data[34] >0){
				$dropCharacter[]=array('id'=>31,'rate'=>$data[34]);
			}
			if($data[35] >0){
				$dropCharacter[]=array('id'=>32,'rate'=>$data[35]);
			}
			if($data[36] >0){
				$dropCharacter[]=array('id'=>33,'rate'=>$data[36]);
			}
			if($data[37] >0){
				$dropCharacter[]=array('id'=>34,'rate'=>$data[37]);
			}
			if($data[38] >0){
				$dropCharacter[]=array('id'=>35,'rate'=>$data[38]);
			}
			if($data[39] >0){
				$dropCharacter[]=array('id'=>36,'rate'=>$data[39]);
			}
			if($data[40] >0){
				$dropCharacter[]=array('id'=>37,'rate'=>$data[40]);
			}
			if($data[41] >0){
				$dropCharacter[]=array('id'=>38,'rate'=>$data[41]);
			}
			if($data[42] >0){
				$dropCharacter[]=array('id'=>39,'rate'=>$data[42]);
			}
			if($data[43] >0){
				$dropCharacter[]=array('id'=>40,'rate'=>$data[43]);
			}
			if($data[44] >0){
				$dropCharacter[]=array('id'=>41,'rate'=>$data[44]);
			}
			if($data[45] >0){
				$dropCharacter[]=array('id'=>42,'rate'=>$data[45]);
			}
			if($data[46] >0){
				$dropCharacter[]=array('id'=>43,'rate'=>$data[46]);
			}
			if($data[47] >0){
				$dropCharacter[]=array('id'=>44,'rate'=>$data[47]);
			}
			if($data[48] >0){
				$dropCharacter[]=array('id'=>45,'rate'=>$data[48]);
			}
			if($data[49] >0){
				$dropCharacter[]=array('id'=>46,'rate'=>$data[49]);
			}
			if($data[50] >0){
				$dropCharacter[]=array('id'=>47,'rate'=>$data[50]);
			}
			if($data[51] >0){
				$dropCharacter[]=array('id'=>48,'rate'=>$data[51]);
			}
			if($data[52] >0){
				$dropCharacter[]=array('id'=>49,'rate'=>$data[52]);
			}
			if($data[53] >0){
				$dropCharacter[]=array('id'=>50,'rate'=>$data[53]);
			}
			if($data[54] >0){
				$dropCharacter[]=array('id'=>51,'rate'=>$data[54]);
			}
			$dropCharacter = serialize($dropCharacter);
			//22-24  character rarity rate
			$rarityRate = array(array('rarity'=>0,'rate'=>$data[56]),
			array('rarity'=>1,'rate'=>$data[57]),
			array('rarity'=>2,'rate'=>$data[58])
			);
			$rarityRate = serialize($rarityRate);
			
			//26-41drop items
			$dropItems = array();
			$items = array(
				array($data[63],$data[64]),
				array($data[65],$data[66]),
				array($data[67],$data[68]),
				array($data[69],$data[70]),
				array($data[71],$data[72]),
				array($data[73],$data[74]),
				array($data[75],$data[76]),
				array($data[77],$data[78]),
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
			if($data[79]||$data[80]||$data[81]||$data[82]||$data[83]){
				$color = serialize(array(
					array('id'=>1,'rate'=>$data[79]),
					array('id'=>2,'rate'=>$data[80]),
					array('id'=>3,'rate'=>$data[81]),
					array('id'=>4,'rate'=>$data[82]),
					array('id'=>5,'rate'=>$data[83]),
				));
			}else{
				$color = '';
			}
			if($data[85]||$data[86]||$data[87]||$data[88]){
				$levelRange = serialize(array(//1~20	21~50	51~80	81~100
					array('s'=>1,'e'=>20,'rate'=>$data[85]),
					array('s'=>21,'e'=>50,'rate'=>$data[86]),
					array('s'=>51,'e'=>80,'rate'=>$data[87]),
					array('s'=>81,'e'=>100,'rate'=>$data[88])
				));
			}else{
				$levelRange = '';
			}
			$unlockGoldReward = $data[90];
			$unlockDropItems = array();
			$unlockItems = array(
				array($data[91],$data[92]),
				array($data[93],$data[94]),
				array($data[95],$data[96]),
				array($data[97],$data[98]),
				array($data[99],$data[100]),
				array($data[101],$data[102]),
				array($data[103],$data[104]),
				array($data[105],$data[106]),
			);
			foreach ($unlockItems as $item){
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
					$unlockDropItems[]=array('id'=>$id,'t'=>$type,'rate'=>$itemRate);
				}
			}
			$unlockDropItems = serialize($unlockDropItems);		
			$skillsRare = '';
			if($data[107] || $data[108]||$data[109]||$data[110]||$data[111]){
				if($data[107]){
					$skillsRare['1']=$data[107];
				}
				if($data[108]){
					$skillsRare['2']=$data[108];
				}
				if($data[109]){
					$skillsRare['3']=$data[109];
				}
				if($data[110]){
					$skillsRare['4']=$data[110];
				}
				if($data[111]){
					$skillsRare['5']=$data[111];
				}
			}
			$chance = array();
			if($data[60] >0){
				$chance[1] = $data[60];
				if($data[61] >0){
					$chance[2] = $data[61];
					if($data[62] >0){
						$chance[3] = $data[62];
					}
				}
			}
			if(empty($chance)){
				$skillsParam = '';
			}else{
				$skillsParamArr['chance'] = $chance;
				if($skillsRare){
					$skillsParamArr['rare'] = $skillsRare; 
				}
				$skillsParam = serialize($skillsParamArr);
			}
			$personality = array();
			if($data[113]){
				$personality['1'] = $data[113];
			}
			if($data[114]){
				$personality['2'] = $data[114];
			}
			if($data[115]){
				$personality['3'] = $data[115];
			}
			if($data[116]){
				$personality['4'] = $data[116];
			}
			if($data[117]){
				$personality['5'] = $data[117];
			}
			if(empty($personality)){
				$personalityParam = '';
			}else{
				$personalityParam = serialize($personality);
			}
			
			$command = Yii::app()->db->createCommand("INSERT INTO questRankDrop (
			`firstDropCharacterRate`,`dropCharacterRate`,`dropCharacter`,`rarityRate`,`firstDropItems`,`dropItems`,
			`color`,`levelRange`,`unlockGoldReward`,`unlockDropItems`,`skillsParam`,`personalityParam`		
			)VALUES (
			'$dropCharacterRate','$dropCharacterRate','$dropCharacter','$rarityRate','$dropItems','$dropItems',
			'$color','$levelRange','$unlockGoldReward','$unlockDropItems','$skillsParam','$personalityParam'
			)");
			$command->execute();
		}
		fclose($handle);
	}

}