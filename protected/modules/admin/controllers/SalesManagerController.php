<?php

class SalesManagerController extends Controller{
    public $layout='/layouts/support';
    
    public function actionIndex() {
        $this->render('index');
    }
}
