<?php
class DataSkill{
    static public function run($filename)
    {
        $handle = fopen($filename, 'r');

        $columns = array(
            'id', 'name', 'memo', 'type', 'rare', 'maxLevel', 
        );
        fgetcsv($handle);
        fgetcsv($handle);
        Yii::app()->db->createCommand()->truncateTable('skill');
        while(($data = fgetcsv($handle)) != false){
            $result = array();
            for($i=0; $i<count($columns); $i++){
                $result[$columns[$i]] = $data[$i];
            }
            self::insertData($result);
        }
        fclose($handle);
    }

    static function insertData($data)
    {
        $columnMap = array(
            'skillName' => 'id',
            'type' => 'type',
            'rare' => 'rare',
            'maxLevel' => 'maxLevel',
        );

        $skill = array();
        foreach($columnMap as $column=>$key){
            $skill[$column] = $data[$key];
        }
        $skill['createTime'] = time();

        Yii::app()->db->createCommand()->insert('skill', $skill);
    }
}
