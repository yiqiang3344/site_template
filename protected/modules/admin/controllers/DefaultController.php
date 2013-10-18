<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
    
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(WORLD_ADMIN_LOGOUT);
	}
    
    public function actionFlushCache() {
        $flushFlag = false;
		$errorFlag = false;
		$blankFlag = false;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(Yii::app()->params['test']){
                $flushFlag = true;
            }else if ($_POST["verification"] =="") {
            	$blankFlag = true;
			}else if ($_POST["verification"] == $_SESSION['randcode']) {
            	$flushFlag = true;
			}else {
				$errorFlag = true;
			}
            
            if($flushFlag){
                Yii::app()->cache->flush();
            }
        }
        $this->render('flushCache', array('flushFlag' => $flushFlag,'errorFlag' => $errorFlag,'blankFlag' => $blankFlag));
    }
    
    public function actionPhpInfo() {
        echo phpinfo();
    }
}