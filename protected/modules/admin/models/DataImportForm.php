<?php
class DataImportForm extends CFormModel{
    const DATA_INSERT = 0;
    const DATA_CONFIG = 1;
    const DATA_UPDATE = 2;

    public $uploadfile;

    public $modelName;

    public $dataType = self::DATA_INSERT;

    public $updateColumns;

    public function rules(){
        return array(
            array("uploadfile, modelName, dataType", 'required'),
            array("modelName", "checkModel"),
            array("updateColumns", "checkColumns"),
        );
    }

    public function checkColumns(){
    }

    public function checkModel(){
        if(!$this->hasErrors()){
            if(!$this->modelName){
                $this->addError("modelName", "please select modelName");
            }
        }
    }

    public function createSql(){
        $dataHandler = $this->dataHandler;
        return $this->$dataHandler('web');
    }

    public function createContent(){
        $dataHandler = $this->dataHandler;
        return $this->$dataHandler('console');
    }

    protected function insert($scenario){
        $dataModel = new $this->modelName;
        $dataModel->setScenario($scenario);
        return $dataModel->createInsertSql($this->uploadfile);
    }

    protected function update($scenario){
        $dataModel = new $this->modelName;
        $dataModel->setScenario($scenario);
        if(empty($this->updateColumns)){
            $updateColumns = array();
        }else{
            $updateColumns = explode(",", $this->updateColumns);
        }
        return $dataModel->createUpdateSql($this->uploadfile, $updateColumns);
    }

    protected function config($scenario){
        $dataModel = new $this->modelName;
        $dataModel->setScenario($scenario);
        return $dataModel->createConfig($this->uploadfile);
    }

    protected function getDataHandler(){
        $handlers = array(
            self::DATA_INSERT => "insert",
            self::DATA_CONFIG => "config",
            self::DATA_UPDATE => "update",
        );
        return $handlers[$this->dataType];
    }

    public function getModelList(){
        return array(
            array('value'=>'0', 'text'=>'请选择模型'),
            /*
            array('value'=>'EquipData', 'text'=>'equipmentBase'),
            array('value'=>'QuestData', 'text'=>'quest'),
            array('value'=>'TaskData', 'text'=>'task'),
            array('value'=>'TowerData', 'text'=>'tower'),
            array('value'=>'StoreyData', 'text'=>'storey'),
            array('value'=>'StoreyShopData', 'text'=>'storeyShop'),
             */
            array('value'=>'MapData', 'text'=>'map'),
            array('value'=>'AreaData', 'text'=>'area'),
            array('value'=>'StageData', 'text'=>'stage'),
            array('value'=>'QuestData', 'text'=>'quest'),
            array('value'=>'TaskData', 'text'=>'task'),
        );
    }
}
?>
