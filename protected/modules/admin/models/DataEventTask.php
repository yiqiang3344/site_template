<?php

class DataEventTask{

	static public function run($csvFileName){
		$row = 0;
		$handle = fopen($csvFileName,"r");
		$data = fgetcsv($handle, 10000, ",");
		$data = fgetcsv($handle, 10000, ",");
		$db = Yii::app()->db;
		//$command = Yii::app()->db->createCommand("TRUNCATE task");
		//$command->execute();
		$transaction = $db->beginTransaction();
        try{
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
                                $id = Equipment::getBaseId($itemName);
                                if(!$id){
                                    throw new SException("equipment $itemName is not exist");
                                }
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
                for($i=41;$i<177;$i++){
                    if($data[$i]){
                        $dropCharacter[] = array('id'=>$i-40, 'rate'=>$data[$i]);
                    }
                }
                $dropCharacter = empty($dropCharacter)?'':serialize($dropCharacter);

                //rarityRate
                $rarityRate = array();
                for($i=178;$i<181;$i++){
                    if($data[$i]){
                        $rarityRate[] = array('rarity'=>$i-178, 'rate'=>$data[$i]);
                    }
                }
                $rarityRate = empty($rarityRate)?'':serialize($rarityRate);

                $color = array($data[182], $data[183], $data[184], $data[185], $data[186]);
                if(array_sum($color)>0){
                    array_walk($color, function(&$value, $key){
                        $value = array('id'=>$key+1, 'rate'=>$value);
                    });
                    $color = serialize($color);
                }else{
                    $color = '';
                }
                $levelRange = array('1'=>$data[188], '21'=>$data[189], '51'=>$data[190], '81'=>$data[191]);
                if(array_sum($levelRange)>0){
                    $sToe = array('1'=>20, '21'=>50, '51'=>80, '81'=>100);
                    array_walk($levelRange, function(&$value, $key, $sToe){
                        $value = array('s'=>$key, 'e'=>$sToe[$key], 'rate'=>$value);
                    }, $sToe);
                    $levelRange = serialize($levelRange);
                }else{
                    $levelRange = '';
                }

                $chance = array();
                if($data[193]){
                    $chance[1] = $data[193];
                    if($data[194]){
                        $chance[2] = $data[194];
                        if($data[195]){
                            $chance[3] = $data[195];
                        }
                    }
                }
                $skillsRare = array('1'=>$data[196], '2'=>$data[197], '3'=>$data[198], '4'=>$data[199], '5'=>$data[200]);
                $skillsRare = array_filter($skillsRare, function($value){
                    return $value>0 ? true : false;
                });
                $skillsRare = empty($skillsRare) ? array('1'=>100) : $skillsRare;

                if(empty($chance)){
                    $skillsParam = '';
                }else{
                    $skillsParamArr['chance'] = $chance;
                    $skillsParamArr['rare'] = $skillsRare; 
                    $skillsParam = serialize($skillsParamArr);
                }
                $personality = array('1'=>$data[202], '2'=>$data[203], '3'=>$data[204], '4'=>$data[205], '5'=>$data[206]);
                $personality = array_filter($personality, function($value){
                    return $value>0;
                });
                $personalityParam = empty($personality) ? '' : serialize($personality);
                if(isset($data[208]) && $data[208]){//固定性格
                    $personalityParam = serialize($data[196]);
                }

                $createTime = time();
                $sql = "INSERT INTO task (
                    `questId`,`taskTitle`,`taskSort`,`event`,`param`,`placeId`,
                    `costAp`,`goldReward`,`reputationReward`,`expReward`,`characterNum`,
                    `monsterMaxLv`,`characterLv`,`firstEquipReward`,`equipReward`,`dropCount`,`taskDrop`,`firstDropRate`,
                    `dropRate`,`dropCharacter`,`costTime`,`dropCharacterLV`,`rarityRate`,`color`,`levelRange`,`personalityParam`,`skillsParam`,`createTime`
                )VALUES (
                    '$questId','$taskTitle','$taskSort','$event','$param','$placeId',
                    '$costAp','$goldReward','$reputationReward','$expReward','$characterNum',
                    '$monsterMaxLv','$characterLv','$firstEquipReward','$equipReward','$dropCount','$taskDrop','$dropRate',
                    '$dropRate','$dropCharacter','$costTime','$dropCharacterLV','$rarityRate','$color','$levelRange','$personalityParam','$skillsParam','$createTime'
                )";
                //echo $sql;
                //echo "<hr>";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();
            }
            $transaction->commit();
        }catch(Exception $e){
		    $transaction->rollback();
		    throw $e;
        }
		fclose($handle);
	}
}
