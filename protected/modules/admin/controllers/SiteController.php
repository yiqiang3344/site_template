<?php

class SiteController extends Controller
{
	public function actionLogin()
	{
		$session = Yii::app()->session;
//        if (isset($_GET['uid']) && isset($_GET['token']) && isset($_GET['sign'])) {
//            
//            $client = new SoapClient(WORLD_LOGIN_CHECK_API, array('cache_wsdl'=>WSDL_CACHE_NONE));
//            $flag = $client->checkLogin($_GET['uid'], $_GET['token'], $_GET['sign']);
//            if ($flag) {
				if(isset($session['uid']) && !empty($session['uid']) && isset($session['token']) && !empty($session['token']) && isset($session['sign']) && !empty($session['sign'])) {
	               $model=new LoginForm;
	                if ($model->login()) {
	                    $this->redirect($this->createUrl('default/index'));
	                }
				}
//            }
//        }
        $this->redirect(WORLD_ADMIN_LOGIN);
	}

    public function actionError(){
	    if($error=Yii::app()->errorHandler->error){
            header("HTTP/1.0 200 ");
            if($error['type'] != 'SException'){
                error_log($error['message']);
            }
	    	if(Yii::app()->request->isAjaxRequest)
                $this->error($error['message'], $error['errorCode']);
	    	else
	        	$this->render('error', $error);
	    }
    }
}