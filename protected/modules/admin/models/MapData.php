<?php
class MapData extends DataImport {
    protected $tableName = 'map';

    public function getConfigData($record){
    }

    public function getInsertData($record){
        $insertData['mapId'] = $record[0];
        $insertData['preMapId'] = $record[1];
        $insertData['nextMapId'] = $record[2];
        $insertData['areaList'] = $this->getListString($record[3]);
        $insertData['targeIds'] = $this->getListString($record[4]);
        $insertData['conditionId'] = $record[5];
        $insertData['mapName'] = $this->quote($record[6]);
        $insertData['mapDesc'] = $this->quote($record[7]);
        return $insertData;
    }
}
