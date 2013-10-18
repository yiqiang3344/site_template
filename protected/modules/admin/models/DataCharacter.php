<?php
class DataCharacter{
    static public function run($filename) {
        $columns = array(
            'id', 'nameJp', 'templateId', 'memo', 'rarity', 'jobId', 'sex', 'growAge', 'agingAge', 'life', 
            'attackTimes', 'restoreRange', 'cri', 'hp', 'attack', 'speed', 'indirectAttack', 'assistAttack',
            'assistDefend', 'restore', 'total', 'hpMaxGift', 'attackGift', 'speedGift', 'indirectAttackGift',
            'assistAttackGift', 'assistDefendGift', 'restoreGift', 'rare', 'personalityRare', 'note',
        );

		$handle = fopen($filename,"r");
        //Titles
        fgetcsv($handle);
        fgetcsv($handle);

        //Yii::app()->db->createCommand()->truncateTable('job');
        Yii::app()->db->createCommand()->truncateTable('characterTemplate');
        while(($data = fgetcsv($handle)) != false){
            $result = array();
            for($i=0; $i<count($data); $i++){
                $result[$columns[$i]] = $data[$i];
            }
            //self::insertJobData($result);
            self::insertCharacterTemplateData($result);
        }
        fclose($handle);
    }

    static public function insertJobData($data)
    {
        $nameJP2EN = array(
            '戦士' => 'Warrior',
            '騎士' => 'Knight',
            '幻術師' => 'Magician',
            '僧侶' => 'Monk',
            '神官' => 'Cleric',
            '魔術師' => 'Wizard',
            '魔女' => 'Witch',
            '剣闘士' => 'Barbarian',
            'アーチャー' => 'Archer',
            'ヴァルキリー' => 'Valkyrie',
            '祈祷師' => 'Shaman',
            '巫女' => 'Sibyl',
            'サムライ' => 'Samurai',
            'ニンジャ' => 'Ninja',
            '聖騎士' => 'Paladin',
            '魔騎士' => 'Warrior Mage',
            '冒険者' => 'Adventurer',
        );
        $name = $nameJP2EN[$data['nameJp']];

        $job = array(
            'jobName' => $name,
            'rarity' => $data['rarity'],
            'sex' => $data['sex'],
            'createTime' => time(),
        );

        Yii::app()->db->createCommand()->insert('job', $job);
    }

    static public function insertCharacterTemplateData($data)
    {
        $columnMap = array(
            'characterTemplateId' => 'templateId',
            'jobId'             => 'jobId',
            'growAgeBase'       => 'growAge',
            'agingAgeBase'      => 'agingAge',
            'lifeBase'          => 'life',
            'hpMaxBase'         => 'hp',
            'attackBase'        => 'attack',
            'hitNum'            => 'attackTimes',
            'speedBase'         => 'speed',
            'assistAttackBase'  => 'assistAttack',
            'indirectAttackBase'=> 'indirectAttack',
            'assistDefendBase'  => 'assistDefend',
            'restoreBase'       => 'restore',
            'restoreRange'      => 'restoreRange',
            'cri'               => 'cri',
            'hpMaxGift'         => 'hpMaxGift',
            'attackGift'        => 'attackGift',
            'speedGift'         => 'speedGift',
            'assistAttackGift'  => 'assistAttackGift',
            'indirectAttackGift'=> 'indirectAttackGift',
            'assistDefendGift'  => 'assistDefendGift',
            'restoreGift'       => 'restoreGift',
        );

        $seriesMap = array(
            '正常' => 0,
            '结婚' => 1,
            '合成' => 2,
            '万圣节活动' => 4,
            'V&B'  => 5,
        );

        $functionTypeMap = array(
            1 => 0,
            2 => 1,
            3 => 0,
            4 => 2,
            5 => 2,
            6 => 1,
            7 => 1,
            8 => 0,
            9 => 3,
            10 => 3,
            11 => 4,
            12 => 4,
            13 => 0,
            14 => 4,
            15 => 5,
            16 => 5,
            17 => 6,
        );

        $characterTemplate = array();
        foreach($columnMap as $column=>$key){
            $characterTemplate[$column] = $data[$key];
        }
        $characterTemplate['series'] = $seriesMap[$data['memo']];
        if($characterTemplate['series'] == 1){
            $characterTemplate['functionType'] = 7;
        }else if($characterTemplate['series'] == 2){
            $characterTemplate['functionType'] = 8;
        }else{
            $characterTemplate['functionType'] = $functionTypeMap[$characterTemplate['jobId']];
        }
        if($data['rare'] == '' || $data['rare'] == 'null'){
            $characterTemplate['rare'] = null;
        }else{
            $characterTemplate['rare'] = $data['rare'];
        }
        if($data['personalityRare'] == ''){
            $characterTemplate['personalityRare'] = null;
        }else{
            $characterTemplate['personalityRare'] = serialize(explode(',', $data['personalityRare']));
        }
        if($characterTemplate['series'] == 4){
            $characterTemplate['picType'] = 1;
            $characterTemplate['nameType'] = 1;
        }else if($characterTemplate['series'] == 5){
            $characterTemplate['picType'] = 1;
            if($characterTemplate['rare'] == 3){
                $characterTemplate['nameType'] = 1;
            }else{
                $characterTemplate['nameType'] = 0;
            }
        }else{
            $characterTemplate['picType'] = 0;
            $characterTemplate['nameType'] = 0;
        }

        $characterTemplate['createTime'] = time();

        Yii::app()->db->createCommand()->insert('characterTemplate', $characterTemplate);
    }
}
