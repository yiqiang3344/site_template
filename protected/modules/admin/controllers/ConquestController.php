<?php

class ConquestController extends Controller{
    public $layout = "conquest";
    
    public function filters() {
        return array(
        );
    }
    
    public function actionTownList() {
        $dataList = array();
        $townList = Town::getAllData();
        foreach ($townList as $town) {
            $garrison = $town->getGarrison();
            $armyList = array();
            foreach ($garrison as $armyId) {
                $army = Yii::app()->objectLoader->load('Army', $armyId);
                $armyList[] = $army;
            }
            $area = Yii::app()->objectLoader->load('Area', $town->areaId);
            $dataList[] = array('town' => $town, 'armyList' => $armyList, 'area' => $area);
        }
        $this->render('townList', array('dataList' => $dataList));
    }
    
    public function actionTownDetail() {
        $townId = $_GET['townId'];
        if (preg_match("/^\d+$/", $townId)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            if ($town->isNew() !== true) {
                $area = Yii::app()->objectLoader->load('Area', $town->areaId);
                $garrison = $town->getGarrison();
                $armyList = array();
                foreach ($garrison as $armyId) {
                    $army = Yii::app()->objectLoader->load('Army', $armyId);
                    $armyDetail = ConquestModel::getArmyDetail($armyId);
                    $armyList[] = $armyDetail;
                }
                
                $this->render('townDetail', array('town' => $town, 'area' =>$area, 'armyList' => $armyList));
            }
        }
    }
    
    public function actionArmyRetreat() {
        $this->isAjax = true;
        $armyId = $_GET['armyId'];
        if (preg_match("/^\d+$/", $armyId)) {
            $army = Yii::app()->objectLoader->load('Army', $armyId);
            $town = Yii::app()->objectLoader->load('Town', $army->garrisonTownId);
            $army->retreat();
            $town->checkTownStatus();
            $this->display('');
        }
    }
    
    public function actionChangeFightingBar() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        $operation = $_GET['operation'];
        $once = $_GET['once'];
        if (preg_match("/^\d+$/", $townId) and ($operation == 'add' or $operation == 'reduce') and (preg_match("/^\d+$/", $once))) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            if ($operation == 'reduce') {
                $once = 0 - $once;
            }
            $town->changeFightingBar($once);
            $town->checkTownStatus();
            $this->display('');
        }
    }
    
    public function actionRefreshDanger() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        if (preg_match("/^\d+$/", $townId)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->refreshDanger();
            $this->display('');
        }
    }
    
    public function actionChangeImportance() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        $num = $_GET['num'];
        if (preg_match("/^\d+$/", $townId) and preg_match("/^\d+$/", $num)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->importance = $num;
            $town->saveAttributes(array('importance'));
            $this->display('');
        }
    }
}

?>
