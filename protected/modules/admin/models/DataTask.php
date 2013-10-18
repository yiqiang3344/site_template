<?php

class DataTask{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 1000, ",");
		$data = fgetcsv($handle, 1000, ",");
		$db = Yii::app()->db;
		$command = Yii::app()->db->createCommand("TRUNCATE task");
		$command->execute();
		while ($data = fgetcsv($handle, 1000, ",")) {
			if(!isset($data[1]) || $data[2]==false){
				break;
			}
			$taskTitle = $data[1];
			$questTitle = $data[2];
			
			$command1 = $db->createCommand('select * from quest where questTitle = :questTitle');
			$command1->bindValue(':questTitle',$questTitle);
			$record = $command1->queryRow();
			$sortParam = explode('_',$taskTitle);
			
			$taskSort = intval($sortParam[3]);
			$questId = $record['questId'];
			$event = 'questBattle';
			$costTime = $data[6];
			
			$placeName = $data[7];
			$command2 = $db->createCommand("select * from place where placeName=:placeName");
			$command2->bindValue(':placeName',$placeName);
			$record = $command2->queryRow();
			$placeId = $record['placeId'];
			
			$monsterName = $data[8];
			$command3 = $db->createCommand('select * from monsterBasic where monsterName=:monsterName');
			$command3->bindValue(':monsterName',$monsterName);
			$record = $command3->queryRow();
			$monsterId = $record['monsterBasicId'];
			$param = serialize(array('monsterId'=>$monsterId,'monsterLevel'=>$data[9]));
			
			$costAp = $data[10];
			$goldReward = $data[11];
			$reputationReward = $data[12];
			$expReward = $data[14];
			
			$characterLv = $data[16];
			$characterNum = $data[17];
			$monsterMaxLv = $data[18];
			
			//10-25 item 0 equip,1 uitem,2 citem,3 eitem,4 sitem
			$equipReward = false;
			$items = array(
						array($data[21],$data[22]),
						array($data[23],$data[24]),
						array($data[25],$data[26]),
						array($data[27],$data[28]),
						array($data[29],$data[30]),
						array($data[31],$data[32]),
						array($data[33],$data[34]),
						array($data[35],$data[36]),
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
							$command4 = $db->createCommand('select * from equipmentBase where baseName=:baseName');
							$command4->bindValue(':baseName',$itemName);
							$record = $command4->queryRow();
							$id = $record['equipmentBaseId'];
						}
					}
					$equipReward[]=array('id'=>$id,'t'=>$type,'rate'=>$itemRate);
				}
			}
			$equipReward = $equipReward?serialize($equipReward):'';
			$firstEquipReward =  $equipReward;
			
			// character drop
			$dropCount = $data[37];
			$dropCharacterLV = $data[38];
			$taskDrop = $data[39];
			$firstDropRate = $dropRate = $data[40];
			
			$dropCharacter = array();		
			if($data[41]){
				$dropCharacter[]=array('id'=>1,'rate'=>$data[41]);
			}
			if($data[42]){
				$dropCharacter[]=array('id'=>2,'rate'=>$data[42]);
			}
			if($data[43]){
				$dropCharacter[]=array('id'=>3,'rate'=>$data[43]);
			}
			if($data[44]){
				$dropCharacter[]=array('id'=>4,'rate'=>$data[44]);
			}
			if($data[45]){
				$dropCharacter[]=array('id'=>5,'rate'=>$data[45]);
			}
			if($data[46]){
				$dropCharacter[]=array('id'=>6,'rate'=>$data[46]);
			}
			if($data[47]){
				$dropCharacter[]=array('id'=>7,'rate'=>$data[47]);
			}
			if($data[48]){
				$dropCharacter[]=array('id'=>8,'rate'=>$data[48]);
			}
			if($data[49]){
				$dropCharacter[]=array('id'=>9,'rate'=>$data[49]);
			}
			
			
			if($data[50]){
				$dropCharacter[]=array('id'=>10,'rate'=>$data[50]);
			}
			if($data[51]){
				$dropCharacter[]=array('id'=>11,'rate'=>$data[51]);
			}
			if($data[52]){
				$dropCharacter[]=array('id'=>12,'rate'=>$data[52]);
			}
			if($data[53]){
				$dropCharacter[]=array('id'=>13,'rate'=>$data[53]);
			}
			if($data[54]){
				$dropCharacter[]=array('id'=>14,'rate'=>$data[54]);
			}
			if($data[55]){
				$dropCharacter[]=array('id'=>15,'rate'=>$data[55]);
			}
			if($data[56]){
				$dropCharacter[]=array('id'=>16,'rate'=>$data[56]);
			}
			if($data[57]){
				$dropCharacter[]=array('id'=>17,'rate'=>$data[57]);
			}
			if($data[58]){
				$dropCharacter[]=array('id'=>18,'rate'=>$data[58]);
			}
			if($data[59]){
				$dropCharacter[]=array('id'=>19,'rate'=>$data[59]);
			}
			
			if($data[60]){
				$dropCharacter[]=array('id'=>20,'rate'=>$data[60]);
			}
			if($data[61]){
				$dropCharacter[]=array('id'=>21,'rate'=>$data[61]);
			}
			if($data[62]){
				$dropCharacter[]=array('id'=>22,'rate'=>$data[62]);
			}
			if($data[63]){
				$dropCharacter[]=array('id'=>23,'rate'=>$data[63]);
			}
			if($data[64]){
				$dropCharacter[]=array('id'=>24,'rate'=>$data[64]);
			}
			if($data[65]){
				$dropCharacter[]=array('id'=>25,'rate'=>$data[65]);
			}
			if($data[66]){
				$dropCharacter[]=array('id'=>26,'rate'=>$data[66]);
			}
			if($data[67]){
				$dropCharacter[]=array('id'=>27,'rate'=>$data[67]);
			}
			if($data[68]){
				$dropCharacter[]=array('id'=>28,'rate'=>$data[68]);
			}
			if($data[69]){
				$dropCharacter[]=array('id'=>29,'rate'=>$data[69]);
			}
			
			if($data[70]){
				$dropCharacter[]=array('id'=>30,'rate'=>$data[70]);
			}
			if($data[71]){
				$dropCharacter[]=array('id'=>31,'rate'=>$data[71]);
			}
			if($data[72]){
				$dropCharacter[]=array('id'=>32,'rate'=>$data[72]);
			}
			if($data[73]){
				$dropCharacter[]=array('id'=>33,'rate'=>$data[73]);
			}
			if($data[74]){
				$dropCharacter[]=array('id'=>34,'rate'=>$data[74]);
			}
			if($data[75]){
				$dropCharacter[]=array('id'=>35,'rate'=>$data[75]);
			}
			if($data[76]){
				$dropCharacter[]=array('id'=>36,'rate'=>$data[76]);
			}
			if($data[77]){
				$dropCharacter[]=array('id'=>37,'rate'=>$data[77]);
			}
			if($data[78]){
				$dropCharacter[]=array('id'=>38,'rate'=>$data[78]);
			}
			if($data[79]){
				$dropCharacter[]=array('id'=>39,'rate'=>$data[79]);
			}
			
			if($data[80]){
				$dropCharacter[]=array('id'=>40,'rate'=>$data[80]);
			}
			if($data[81]){
				$dropCharacter[]=array('id'=>41,'rate'=>$data[81]);
			}
			if($data[82]){
				$dropCharacter[]=array('id'=>42,'rate'=>$data[82]);
			}
			if($data[83]){
				$dropCharacter[]=array('id'=>43,'rate'=>$data[83]);
			}
			if($data[84]){
				$dropCharacter[]=array('id'=>44,'rate'=>$data[84]);
			}
			if($data[85]){
				$dropCharacter[]=array('id'=>45,'rate'=>$data[85]);
			}
			if($data[86]){
				$dropCharacter[]=array('id'=>46,'rate'=>$data[86]);
			}
			if($data[87]){
				$dropCharacter[]=array('id'=>47,'rate'=>$data[87]);
			}
			if($data[88]){
				$dropCharacter[]=array('id'=>48,'rate'=>$data[88]);
			}
			if($data[89]){
				$dropCharacter[]=array('id'=>49,'rate'=>$data[89]);
			}
			
			if($data[90]){
				$dropCharacter[]=array('id'=>50,'rate'=>$data[90]);
			}
			if($data[91]){
				$dropCharacter[]=array('id'=>51,'rate'=>$data[91]);
			}
			$dropCharacter = empty($dropCharacter)?'':serialize($dropCharacter);
			
			//rarityRate
			$rarityRate = array();
			if ($data[93]){
				$rarityRate[]=array('rarity'=>0,'rate'=>$data[93]);
			}
			if ($data[94]){
				$rarityRate[]=array('rarity'=>1,'rate'=>$data[94]);
			}
			if ($data[95]){
				$rarityRate[]=array('rarity'=>2,'rate'=>$data[95]);
			}
			$rarityRate = empty($rarityRate)?'':serialize($rarityRate);
			
			if($data[97] ||$data[98]||$data[99]||$data[100]||$data[101]){
				$color = serialize(array(
					array('id'=>1,'rate'=>$data[97]),
					array('id'=>2,'rate'=>$data[98]),
					array('id'=>3,'rate'=>$data[99]),
					array('id'=>4,'rate'=>$data[100]),
					array('id'=>5,'rate'=>$data[101]),
				));
			}else{
				$color = '';
			}
			if($data[103] || $data[104]||$data[105]||$data[106]){
				$levelRange = serialize(array(//1~20	21~50	51~80	81~100
					array('s'=>1,'e'=>20,'rate'=>$data[103]),
					array('s'=>21,'e'=>50,'rate'=>$data[104]),
					array('s'=>51,'e'=>80,'rate'=>$data[105]),
					array('s'=>81,'e'=>100,'rate'=>$data[106])
				));
			}else{
				$levelRange = '';
			}
			
			if($data[111] || $data[112]||$data[113]||$data[114]||$data[115]){
				if($data[111]){
					$skillsRare['1']=$data[111];
				}
				if($data[112]){
					$skillsRare['2']=$data[112];
				}
				if($data[113]){
					$skillsRare['3']=$data[113];
				}
				if($data[114]){
					$skillsRare['4']=$data[114];
				}
				if($data[115]){
					$skillsRare['5']=$data[115];
				}
			}else{
				$skillsRare['1'] = 100;
			}
			$chance = array();
			if($data[108]){
				$chance[1] = $data[108];
				if($data[109]){
					$chance[2] = $data[109];
					if($data[110]){
						$chance[3] = $data[110];
					}
				}
			}
			if(empty($chance)){
				$skillsParam = '';
			}else{
				$skillsParamArr['chance'] = $chance;
				$skillsParamArr['rare'] = $skillsRare; 
				$skillsParam = serialize($skillsParamArr);
			}
			$personality = array();
			if($data[117]){
				$personality['1'] = $data[117];
			}
			if($data[118]){
				$personality['2'] = $data[118];
			}
			if($data[119]){
				$personality['3'] = $data[119];
			}
			if($data[120]){
				$personality['4'] = $data[120];
			}
			if($data[121]){
				$personality['5'] = $data[121];
			}
			if(empty($personality)){
				$personalityParam = '';
			}else{
				$personalityParam = serialize($personality);
			}
			
			$createTime = time();
			
			$command = Yii::app()->db->createCommand("INSERT INTO task (
			`questId`,`taskTitle`,`taskSort`,`event`,`param`,`placeId`,
			`costAp`,`goldReward`,`reputationReward`,`expReward`,`characterNum`,
			`monsterMaxLv`,`characterLv`,`firstEquipReward`,`equipReward`,`dropCount`,`taskDrop`,`firstDropRate`,
			`dropRate`,`dropCharacter`,`costTime`,`dropCharacterLV`,`rarityRate`,`color`,`levelRange`,`personalityParam`,`skillsParam`,`createTime`
			)VALUES (
			'$questId','$taskTitle','$taskSort','$event','$param','$placeId',
			'$costAp','$goldReward','$reputationReward','$expReward','$characterNum',
			'$monsterMaxLv','$characterLv','$firstEquipReward','$equipReward','$dropCount','$taskDrop',
			'$dropRate','$dropCharacter','$costTime','$dropCharacterLV','$rarityRate','$color','$levelRange',$personalityParam,$skillsParam,'$createTime'
			)");
			$command->execute();
		}
		fclose($handle);
	}
}
