<?php

class DataController extends Controller
{
	public function actionIndex()
	{
        if(!Yii::app()->params['test']){
			echo "This function can only use in test mode";
            Yii::app()->end();
        }

		if(isset($_POST['submit'])){
			$model = $_POST['model'];
			$fileName = $_FILES["file"]["name"];
			if($fileName){
				$file = CUploadedFile::getInstanceByName('file');
				$model::run($file->getTempName());
			}
		}
		$this->render('index');
	}
}