<?php

class ConquestManagerController extends Controller{
    public $layout='/layouts/support';
    
    public function actionIndex() {
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
        $this->render('index', array('dataList' => $dataList));
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
    
    public function actionChangeDangerMax() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        $num = $_GET['num'];
        if (preg_match("/^\d+$/", $townId) and preg_match("/^\d+$/", $num)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->dangerMax = $num;
            $town->saveAttributes(array('dangerMax'));
            $this->display('');
        }
    }
    
    public function actionChangeFightingBarMax() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        $num = $_GET['num'];
        if (preg_match("/^\d+$/", $townId) and preg_match("/^\d+$/", $num)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->fightingBarMax = $num;
            $town->saveAttributes(array('fightingBarMax'));
            $town->checkTownStatus();
            $this->display('');
        }
    }
    
    public function actionChangeFightingBar() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        $num = $_GET['num'];
        $type = $_GET['type'];
        if (preg_match("/^\d+$/", $townId) and preg_match("/^\d+$/", $num) and ($type == 'add' or $type == 'reduce')) {
            if ($type == 'reduce') {
                $num = 0 - $num;
            }
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->changeFightingBar($num);
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
    
    public function actionRefreshFightingBar() {
        $this->isAjax = true;
        $townId = $_GET['townId'];
        if (preg_match("/^\d+$/", $townId)) {
            $town = Yii::app()->objectLoader->load('Town', $townId);
            $town->refreshFightingBar();
            $this->display('');
        }
    }
}
