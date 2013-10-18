<?php
class AreaData extends DataImport {
    protected $tableName = 'area';

    public function getConfigData($record){
    }

    public function getInsertData($record){
        $insertData['areaId'] = $record[0];
        $insertData['preAreaId'] = $record[1];
        $insertData['nextAreaId'] = $record[2];
        $insertData['mapId'] = $record[3];
        $insertData['stageList'] = $this->getListString($record[4]);
        $insertData['targeIds'] = $this->getListString($record[5]);
        $insertData['conditionId'] = $record[6];
        $insertData['areaName'] = $this->quote($record[7]);
        $insertData['areaDesc'] = $this->quote($record[8]);
        return $insertData;
    }
}
