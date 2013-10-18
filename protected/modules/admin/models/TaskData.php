<?php
class TaskData extends DataImport {
    protected $tableName = 'task';
    //protected $debug = true;
    protected $debugAttribute = 'equipLevelParam';

    public function getConfigData($record) {
        return array();
    }

    public function getInsertData($record) {
        $insertData['taskId'] = $record[0];
        $insertData['questId'] = $record[1];
        $insertData['stageId'] = $record[2];
        $insertData['areaId'] = $record[3];
        $insertData['mapId'] = $record[4];
        $insertData['taskSort'] = $record[5];
        $insertData['isBoss'] = $record[6];
        $insertData['enemyId'] = $this->getEnemyId($record[7]);
        $insertData['enemyLevel'] = $record[8];
        $insertData['rewardsTemplate'] = $this->getRewardTemplate($record[9]);
        $insertData['battleType'] = "'" . $record[10] . "'";
        return $insertData;
    }

    protected function getEnemyId($enemyName){
        $db = Yii::app()->db;
        $command = $db->createCommand('select monsterBasicId from monsterBasic where monsterName=:monsterName');
        $command->bindValue(':monsterName',$enemyName);
        $monsterBasicId = $command->queryScalar();
        return $monsterBasicId;
    }

    protected function getRewardTemplate($params){
        $params = $this->getListString($params, false);
        $params = explode(",", $params);
        $rewardTemplate = array();
        foreach($params as $param){
            $param = explode("_", $param);
            $rewardTemplate[$param[0]] = array(
                'rewardTemplateId' => $param[1],
                'rewardTemplateType' => $param[2],
            );
        }
        return $this->quote(CJSON::encode($rewardTemplate));
    }
}
?>
