<?php
class TowerData extends DataImport{
    protected $tableName = 'tower';
    //protected $debug = true;
    protected $debugAttribute = 'completeAward';//null;

    public function getConfigData($file) {
    }

    public function getInsertData($file){
        $insertDatas = array();
        $handle = fopen($file, 'r');
        $data = fgetcsv($handle, 1000, ",");
        while ($data = fgetcsv($handle, 1000, ",")) {
            $insertData = array();
            $towerId = $data[0];
            $insertData['towerId'] = $towerId;
            $towerTitle = $data[1];
            $insertData['towerTitle'] = "'" . $towerTitle . "'";
            $boxStoreyId = $data[3];
            $boxStoreyId = explode('，', $boxStoreyId);
            $boxStoreyId = implode(',', $boxStoreyId);
            $insertData['boxStoreyId'] = "'" . $boxStoreyId . "'";
            $enterStoreyId = $data[4];
            $enterStoreyId = explode('，', $enterStoreyId);
            $enterStoreyId = implode(',', $enterStoreyId);
            $insertData['enterStoreyId'] = "'" . $enterStoreyId . "'";
            $startTime = $data[5];
            $startTime = strtotime($startTime);
            $startTime = date('Y-m-d H:i:s', $startTime);
            $insertData['startTime'] = "'" . $startTime . "'";
            $endTime = $data[6];
            $endTime = strtotime($endTime);
            $endTime = date('Y-m-d H:i:s', $endTime);
            $insertData['endTime'] = "'" . $endTime . "'";
            $closeTime = $data[7];
            $closeTime = strtotime($closeTime);
            $closeTime = date('Y-m-d H:i:s', $closeTime);
            $insertData['closeTime'] = "'" . $closeTime . "'";
            $insertDatas[] = $insertData;
        }
        fclose($handle);
        return $insertDatas;
    }
}
?>
