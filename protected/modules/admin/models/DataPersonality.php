<?php
class DataPersonality{
    static public function run($filename)
    {
        $columns = array(
            'id', 'name', 'memo', 'rarity', 'sex', 'hp', 'attack', 'speed', 'indirectAttack',
            'assistAttack', 'assistDefend', 'restore', 'cri', 'learn', 'teach',
        );

		$handle = fopen($filename,"r");
        //Titles
        fgetcsv($handle);
        Yii::app()->db->createCommand()->truncateTable('personality');
        while(($data = fgetcsv($handle)) != false){
            $result = array();
            for($i=0; $i<count($data); $i++){
                $result[$columns[$i]] = $data[$i];
            }
            self::insertData($result);
        }
        fclose($handle);
    }

    static public function insertData($data)
    {
        $columnMap = array(
            'name' => 'id',
            'rare' => 'rarity',
            'sex' => 'sex', 
            'hpMaxFactor' => 'hp',
            'attackFactor' => 'attack',
            'speedFactor' => 'speed',
            'assistAttackFactor' => 'assistAttack',
            'indirectAttackFactor' => 'indirectAttack',
            'assistDefendFactor' => 'assistDefend',
            'restoreFactor' => 'restore',
            'criFactor' => 'cri',
            'learnFactor' => 'learn',
            'teachFactor' => 'teach',
        );

        $personality = array();
        foreach($columnMap as $column=>$key){
            $personality[$column] = $data[$key];
        }
        $personality['createTime'] = time();

        Yii::app()->db->createCommand()->insert('personality', $personality);
    }
}
