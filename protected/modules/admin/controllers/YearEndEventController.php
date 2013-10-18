<?php

class YearEndEventController extends Controller
{
	public function actionIndex(){
        $model = new YearEndEventForm();
        $data['model'] = $model;
        if(isset($_POST['YearEndEventForm'])){
            $model->attributes = $_POST['YearEndEventForm'];
            if ($model->validate()) {
                $sql = $model->insertData();
                $data['sql'] = $sql;
            }
        }
        $this->render('index', $data);
	}
}

