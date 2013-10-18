<?php
class QuestData extends DataImport {
    protected $tableName = 'quest';

    public function getConfigData($record) {
    }

    public function getInsertData($record) {
        $insertData['questId'] = $record[0];
        $insertData['preQuestId'] = $record[1];
        $insertData['nextQuestId'] = $record[2];
        $insertData['stageId'] = $record[3];
        $insertData['areaId'] = $record[4];
        $insertData['mapId'] = $record[5];
        $insertData['taskList'] = $this->getListString($record[6]);
        $insertData['targeIds'] = $this->getListString($record[7]);
        $insertData['questName'] = $this->quote($record[8]);
        $insertData['questDesc'] = $this->quote($record[9]);
        $insertData['costAp'] = $record[10];
        $insertData['readConfig'] = $record[11];
        $insertData['questCategory'] = $record[12];
        $insertData['conditionId'] = $record[13];
        $insertData['requireClearNum'] = $record[14];
        $insertData['requireRoundNum'] = $record[15];
        $insertData['placeId'] = $record[16];
        $insertData['round'] = $this->getRoundParams($record[17]);
        return $insertData;
    }

    protected function getRoundParams($params){
        $params = $this->getListString($params, false);
        $params = explode(",", $params);
        $roundParams = array();
        foreach($params as $param){
            $param = explode("_", $param);
            $roundParams[$param[0]] = $param[1];
        }
        return $this->quote(CJSON::encode($roundParams));
    }
}
?>
