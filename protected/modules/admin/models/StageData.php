<?php
class StageData extends DataImport {
    protected $tableName = 'stage';

    public function getConfigData($record){
    }

    public function getInsertData($record){
        $insertData['stageId'] = $record[0];
        $insertData['preStageId'] = $record[1];
        $insertData['nextStageId'] = $record[2];
        $insertData['areaId'] = $record[3];
        $insertData['mapId'] = $record[4];
        $insertData['questList'] = $this->getListString($record[5]);
        $insertData['targeIds'] = $this->getListString($record[6]);
        $insertData['conditionId'] = $record[7];
        $insertData['stageName'] = $this->quote($record[8]);
        $insertData['stageDesc'] = $this->quote($record[9]);
        $insertData['key'] = $record[10];
        return $insertData;
    }
}
