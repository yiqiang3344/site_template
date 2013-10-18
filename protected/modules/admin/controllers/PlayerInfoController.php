<?php
class PlayerInfoController extends Controller {
	public function actionIndex() {
        $model = new PlayerInfoForm;
		$playerInfo = array();
        if (isset($_POST['PlayerInfoForm'])) {
            $model->attributes = $_POST['PlayerInfoForm'];
            if ($model->validate()) {
				$playerInfo = $model->getPlayerInfo();
            }
        }
		$this->render('index', array('playerInfo'=>$playerInfo, 'model' => $model));
	}

	public function actionLogin() {
	    Yii::app()->session->clear();
        if(isset($_REQUEST['UID'])){
			$sigKey = '85b632e5894a6cf36829c8d385885280';
            $sig = hash('sha256',$_REQUEST['UID'].$sigKey);
			$url = WORLD_URL.'&UID='.$_REQUEST['UID'].'&sig='.$sig.'&bSeason2=1';
			header("Location:".$url);
        }else{
            $this->render('index');
        }
	}
}
?>