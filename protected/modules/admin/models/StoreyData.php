<?php
class StoreyData extends DataImport{
    protected $tableName = 'storey';
    //protected $debug = true;
    protected $debugAttribute = 'towerId';

    protected $fileName;

    public function getConfigData($file) {
        $handle = fopen($file, 'r');
        $config = array();
        while ($data = fgetcsv($handle, 1000, ',')) {
            if(intval($data[1] < 0)){
                $config[$data[2]] = $data[3];
            }
        }
        fclose($handle);
        return $config;
    }

    public function getInsertData($file){
        $insertDatas = array();
        $handle = fopen($file, 'r');
        while ($data = fgetcsv($handle, 1000, ",")) {
            if(!isset($data[0]) or intval($data[0])==0){
                continue;
            }
            $insertData = array();

            $basicData = array_slice($data, 0, 10);
            $insertData += $this->getBasicInfo($basicData);

            $entryStoreyData = array_slice($data, 10, 3);
            $insertData += $this->getEntryStoreyData($entryStoreyData);

            $monsterData = array_slice($data, 13, 10);
            $insertData['monster'] = $this->getMonsterParam($monsterData);

            $basicRewardData = array_slice($data, 23, 6);
            $insertData += $this->getBasicReward($basicRewardData);

            $equipRewardData = array_slice($data, 29, 44);
            $insertData['equipReward'] = $this->getEquipReward($equipRewardData);

            $itemRewardData = array_slice($data, 73, 16);
            $insertData['itemReward'] = $this->getItemReward($itemRewardData);

            $specialRewardData = array_slice($data, 89, 20);
            $insertData['specialReward'] = $this->getSpecialReward($specialRewardData);

            $characterRewardData = array_slice($data, 109);
            $insertData['characterReward'] = $this->getCharacterReward($characterRewardData);

            $insertData['createTime'] = time();

            $insertDatas[] = $insertData;
        }
        fclose($handle);
        return $insertDatas;
    }

    protected function getBasicInfo($data){
        $storeyTitle = $data[2];
        $storeyName = $data[3];
        $storeyTask = $data[7];
        $area = $data[6];
        unset($data[2]);
        unset($data[3]);
        unset($data[6]);
        unset($data[7]);
        $keys = array('storeyId', 'storeySort', 'towerId', 'shortCut', 'costAp', 'costTime');
        $basicInfo = array_combine($keys, $data);
        $basicInfo['storeyTitle'] = "'$storeyTitle'";
        $basicInfo['storeyName'] = "'$storeyName'";
        $basicInfo['storeyTask'] = "'$storeyTask'";
        return $basicInfo;
    }

    protected function getEntryStoreyData($data){
        array_walk($data, function(&$value){
            $value = explode('，', $value);
            $value = implode(',', $value);
            $value = "'$value'";
        });
        $keys = array('nextStorey', 'nextStoreyHidden', 'nextStoreyTemp');
        return array_combine($keys, $data);
    }

    protected function getBasicReward($data){
        $keys = array('goldReward', 'reputationReward', 'contributionReward', 'fpReward', 'spReward', 'expReward');
        return array_combine($keys, $data);
    }

    protected function getMonsterParam($data){
        $monsterName = $data[0];
        $monsterLevel = $data[1];
        $command = Yii::app()->db->createCommand('select monsterBasicId from monsterBasic where monsterName=:monsterName');
        $command->bindValue(':monsterName', $monsterName);
        $monsterBasicId = $command->queryScalar();
        $monsterParam['monsterBasicId'] = $monsterBasicId;
        $monsterParam['monsterLevel'] = $monsterLevel;
        $factor['hpMax'] = $data[2];
        $factor['attack'] = $data[3];
        $factor['speed'] = $data[4];
        $factor['restore'] = $data[5];
        $monsterParam['factor'] = $factor;
        $attributes['hpMax'] = $data[6];
        $attributes['attack'] = $data[7];
        $attributes['speed'] = $data[8];
        $attributes['restore'] = $data[9];
        $monsterParam['attributes'] = $attributes;
        $monsterParam = "'" . serialize($monsterParam) . "'";
        return $monsterParam;
    }

    protected function getEquipReward($data){
        $maxRecuireLevel = array_shift($data);
        $equipParam['maxRecuireLevel'] = $maxRecuireLevel;
        $equip = array_chunk($data, 13);
        $levelRange = array_combine(array(0, 21, 51, 81), array_pop($equip));
        array_walk($equip, function(&$value, $key){
            $equipment['baseId'] = array_shift($value);
            $equipment['rate'] = array_shift($value);
            $colorParm = array_slice($value, 0, 5);
            array_walk($colorParm, function(&$param, $key){
                $color['color'] = $key + 1;
                $color['rate'] = $param;
                $param = $color;
            });
            $equipment['color'] = $colorParm;
            $levelParam = array_chunk(array_slice($value, 5, 6), 2);
            array_walk($levelParam, function(&$level, $key){
                $value['level'] = $level[0];
                $value['rate'] = $level[1];
                $level = $value;
            });
            $equipment['level'] = $levelParam;
            $value = $equipment;
        });
        $equip = array_filter($equip, function($param){
            return $param['baseId'];
        });
        $equipParam['equip'] = $equip;
        foreach(array(0=>20, 21=>50, 51=>80, 81=>100) as $minLevel=>$maxLevel){
            $rate = $levelRange[$minLevel];
            $levelRange[$minLevel] = compact("minLevel", "maxLevel", "rate");
        }
        $equipParam['levelRange'] = array_values($levelRange);
        if(empty($equipParam['equip'])){
            return "''";
        }
        $equipParam = "'" . serialize($equipParam) . "'";
        return $equipParam;
    }

    protected function getItemReward($data){
        $data = array_chunk($data, 2);
        $data = array_filter($data, function($value){
            return $value[0];
        });
        array_walk($data, function(&$item, $key){
            $itemName = $item[0];
            $type = array('U'=>1, 'C'=>2, 'E'=>3, 'M'=>5, 'T'=>6);
            $param = explode("_", $itemName);
            $value['id'] = intval($param[2]);
            $value['type'] = $type[$param[0]];
            $value['rate'] = $item[1];
            $item = $value;
        });
        if(empty($data)){
            return "''";
        }
        $data = "'" . serialize($data) . "'";
        return $data;
    }

    protected function getSpecialReward($data){
        $data = array_chunk($data, 6);
        $addition = array_pop($data);
        $drop = $data;
        array_walk($drop, function(&$value, $key){
            $clone = array();
            $clone['templateId'] = $value[0];
            $clone['type'] = $value[1];
            $clone['rare'] = $value[2];
            $clone['level'] = $value[3];
            $clone['num'] = $value[4];
            $clone['rate'] = $value[5];
            $value = $clone;
        });
        $drop = array_filter($drop, function($value){
            return $value['templateId'];
        });
        $addititonType = array_shift($addition);
        $addititonTimes = array_shift($addition);
        if($addititonTimes or $addititonType){
            $addition = array(
                'type' => $addititonType,
                'times' => $addititonTimes,
            );
        }
        if(empty($drop) and empty($addition)){
            return "''";
        }
        $specialReward = compact("drop", "addition");
        $specialReward = "'" . serialize($specialReward) . "'";
        return $specialReward;
    }

    protected function getCharacterReward($data){
        $countParam = array_shift($data);
        $characterParam['characterCount'] = $countParam;
        $levelParam = array_shift($data);
        $characterParam['characterLevel'] = $levelParam;
        $rateParam = array_shift($data);
        $characterParam['dropRate'] = $rateParam;

        $rarityParam = array_slice($data, 0, 3);
        array_walk($rarityParam, function(&$rate, $key){
            $value['rarity'] = $key;
            $value['rate'] = $rate;
            $rate = $value;
        });
        $rarityParam = array_filter($rarityParam, function($param){return $param['rate'];});
        $characterParam['rarity'] = $rarityParam;

        //skill
        $skillNum = array_combine(array(1,2,3), array_slice($data, 3, 3));
        $skillNum = array_filter($skillNum, function($num){return $num;});
        $skillParam['chance'] = $skillNum;
        $skillRare = array_combine(array(1,2,3,4,5), array_slice($data, 6, 5));
        $skillRare = array_filter($skillRare, function($rate){return $rate;});
        $skillParam['rare'] = $skillRare;
        $characterParam['skill'] = $skillParam;

        //personality
        $personalityParam = array_slice($data, 11, 6);
        $personalityId = array_pop($personalityParam);
        if($personalityId){
            $personalityParam = compact("personalityId");
        }else{
            $personalityParam = array_combine(array(1,2,3,4,5), $personalityParam);
            $personalityParam = array_filter($personalityParam, function($rate){return $rate;});
        }
        $characterParam['personality'] = $personalityParam;
        $templateParam = array_slice($data, 17);
        array_walk($templateParam, function(&$rate, $key){
            $value['templateId'] = $key + 1;
            $value['rate'] = $rate;
            $rate = $value;
        });
        $templateParam = array_filter($templateParam, function($param){return $param['rate'];});
        $characterParam['template'] = $templateParam;
        if(empty($templateParam)){
            return "''";
        }
        $characterParam = "'" . serialize($characterParam) . "'";
        return $characterParam;
    }
}
?>
