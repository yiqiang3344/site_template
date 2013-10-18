<?php

class WorldManagerController extends Controller{
    public $layout='/layouts/support';
    
    public function actionIndex() {
        $dataList = array();
        $world = new World;
        $dataList['currentYear'] = $world->getYears();
        $this->render('index', array('dataList' => $dataList));
    }
}
