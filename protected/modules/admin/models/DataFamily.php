<?php
class DataFamily{
    static public function run($filename)
    {
        $handle = fopen($filename, 'r');

        $columns = array(
            'id', 'name', 'memo', 'rare', 'jobId', 'hp', 'attack', 'speed', 'indirectAttack',
            'assistAttack', 'assistDefend', 'restore',
        );
        fgetcsv($handle);
        Yii::app()->db->createCommand()->truncateTable('characterLastName');
        while(($data = fgetcsv($handle)) != false){
            $result = array();
            for($i=0; $i<count($data); $i++){
                $result[$columns[$i]] = $data[$i];
            }
            self::insertData($result);
        }
        fclose($handle);
    }

    static function insertData($data)
    {
        $columnMap = array(
            'lastName' => 'id',
            'characterTemplateId' => 'jobId',
            'rare' => 'rare',
            'hpMaxFactor' => 'hp',
            'attackFactor' => 'attack',
            'speedFactor' => 'speed',
            'assistAttackFactor' => 'assistAttack',
            'indirectAttackFactor' => 'indirectAttack',
            'assistDefendFactor' => 'assistDefend',
            'restoreFactor' => 'restore',
        );

        $family = array();
        foreach($columnMap as $column=>$key){
            $family[$column] = $data[$key];
        }

        Yii::app()->db->createCommand()->insert('characterLastName', $family);
    }
}
