<?php
class EquipData extends DataImport {
    protected $tableName = 'equipmentBase';
    //protected $debug = true;
    protected $debugAttribute = 'equipType';


    public function getConfigData($file) {
        $handle = fopen($file, 'r');
        $data = fgetcsv($handle, 1000, ',');
        $data = fgetcsv($handle, 1000, ',');
        while ($data = fgetcsv($handle, 1000, ',')) {
            if (empty($data[1])) {
                continue;
            }
            if($data[0] !== '//') {
                $baseName = $data[1];
                $name = $data[3];
                $isNew = $data[48];
                if($isNew){
                    $config[$baseName] = $name;
                }
            }
        }
        fclose($handle);
        return $config;
    }

    public function getInsertData($file) {
        $insertDatas = array();
        $handle = fopen($file, 'r');
        $data = fgetcsv($handle, 1000, ',');
        $data = fgetcsv($handle, 1000, ',');

        while ($data = fgetcsv($handle, 1000, ",")) {
            if (empty($data[1])) {
                continue;
            }
            if ($data[0] !== '//') {
                $baseName = $data[1];$insertData['baseName'] = "'".$baseName."'";
                $equipmentBaseId = $data[2];$insertData['equipmentBaseId'] = $equipmentBaseId;
                $category = $data[5];$insertData['category'] = $category;
                $rarity = $data[6];$insertData['rarity'] = $rarity;
                $slot = $data[7];$insertData['slot'] = $slot;
                $characterType = $data[8];$insertData['characterType'] = $characterType;
                $type = $data[9];$insertData['type'] = $type;
                $maxLv = $data[10];$insertData['maxLv'] = $maxLv;
                $hpMax = $data[11];$insertData['hpMax'] = $hpMax;
                $hpMaxPlus = $data[12];$insertData['hpMaxPlus'] = $hpMaxPlus;
                $attack = $data[13];$insertData['attack'] = $attack;
                $attackPlus = $data[14];$insertData['attackPlus'] = $attackPlus;
                $speed = $data[15];$insertData['speed'] = $speed;
                $speedPlus = $data[16];$insertData['speedPlus'] = $speedPlus;
                $indirectAttack = $data[17];$insertData['indirectAttack'] = $indirectAttack;
                $indirectAttackPlus = $data[18];$insertData['indirectAttackPlus'] = $indirectAttackPlus;
                $assistAttack = $data[19];$insertData['assistAttack'] = $assistAttack;
                $assistAttackPlus = $data[20];$insertData['assistAttackPlus'] = $assistAttackPlus;
                $assistDefend = $data[21];$insertData['assistDefend'] = $assistDefend;
                $assistDefendPlus = $data[22];$insertData['assistDefendPlus'] = $assistDefendPlus;
                $restore = $data[23];$insertData['restore'] = $restore;
                $restorePlus = $data[24];$insertData['restorePlus'] = $restorePlus;
                $cri = $data[25];$insertData['cri'] = $cri;
                $criPlus = $data[26];$insertData['criPlus'] = $criPlus;
                $hitNum = $data[27];$insertData['hitNum'] = $hitNum;
                $price = str_replace(',', '', $data[28]);$insertData['price'] = $price;
                $characterLv = $data[29];$insertData['characterLevel'] = $characterLv;
                $job_01 = $data[30];$insertData['job_01'] = $job_01;
                $job_02 = $data[31];$insertData['job_02'] = $job_02;
                $job_03 = $data[32];$insertData['job_03'] = $job_03;
                $job_04 = $data[33];$insertData['job_04'] = $job_04;
                $job_05 = $data[34];$insertData['job_05'] = $job_05;
                $job_06 = $data[35];$insertData['job_06'] = $job_06;
                $job_07 = $data[36];$insertData['job_07'] = $job_07;
                $job_08 = $data[37];$insertData['job_08'] = $job_08;
                $job_09 = $data[38];$insertData['job_09'] = $job_09;
                $job_10 = $data[39];$insertData['job_10'] = $job_10;
                $job_11 = $data[40];$insertData['job_11'] = $job_11;
                $job_12 = $data[41];$insertData['job_12'] = $job_12;
                $job_13 = $data[42];$insertData['job_13'] = $job_13;
                $job_14 = $data[43];$insertData['job_14'] = $job_14;
                $job_15 = $data[44];$insertData['job_15'] = $job_15;
                $job_16 = $data[45];$insertData['job_16'] = $job_16;
                $job_17 = $data[46];$insertData['job_17'] = $job_17;
                $isRarityLimit = $data[47];$insertData['isRarityLimit'] = $isRarityLimit;
                $isNew = $data[48];$insertData['isNew'] = $isNew;
                $equipType = $data[49];$insertData['equipType'] = $equipType;
                $insertDatas[] = $insertData;
            }
        }
        $insertDatas = array_filter($insertDatas, array($this, '_equipFilter'));
        /*array_walk($insertDatas, function($value, $key){
            print_r($value);
            echo '<hr>';
        });
        exit;*/
        return $insertDatas;
    }

    private function _equipFilter($data){
        return isset($data['isNew']) and $data['isNew'];
    }
}
?>
