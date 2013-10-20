<?php
class LoginAction extends CAction
{
	public function run()
    {
        #input
        $FUser = $_POST;
        #start
        $MUser = new User('login');
        $MUser->attributes = $FUser;
        $errors = array();
        $session = Yii::app()->session;
        if($MUser->validate() && $MUser->login()){
            $code = 1;
            $session['login_error_time']=0;
        }else{
            $code = 2;
            if(intval(@$session['login_error_time']))
                $session['login_error_time'] += 1;
            else
                $session['login_error_time']=1;
            $errors = $MUser->getErrors();
        }

        $bind = array(
            'code' => $code,
            'errors' => $errors,
            'userdata'=> Yii::app()->controller->getUD()
        );
        Yii::app()->controller->render($bind);
        Yii::app()->end();
    }
}