<?php
class SiteController extends Controller
{
    /******************************ajax**********************/
    public function actionAjaxVerify(){
        #input
        #start
        $code = 2;
        $verifyUrl = null;
        if(intval(Yii::app()->session['login_error_time'])>=S::MAX_LOGIN_ERROR_TIME){
            $code = 1;
            $verifyUrl = $this->url($this->getId(),'captcha').'/v/'.mt_rand();
        }
        END:
        $bind = array(
            'code' => $code,
            'verifyUrl' => $verifyUrl,
        );
        $this->render($bind);
    }

    public function actionAjaxLogin(){
        #input
        $FUser = $_POST;
        #start
        $MUser = new MUser('login');
        $MUser->attributes = $FUser;
        $errors = array();
        $verifyUrl = null;
        $session = Yii::app()->session;
        if($MUser->validate() && $MUser->login()){
            $code = 1;
            $session['login_error_time']=0;
        }else{
            $code = 2;
            $flag = intval(@$session['login_error_time'])>=S::MAX_LOGIN_ERROR_TIME;
            if(intval(@$session['login_error_time']))
                $session['login_error_time'] += 1;
            else
                $session['login_error_time']=1;
            $errors = $MUser->getErrors();
            if(!$flag && intval($session['login_error_time'])>=S::MAX_LOGIN_ERROR_TIME){
                $code = 3;
                $verifyUrl = $this->url($this->getId(),'captcha').'/v/'.mt_rand();
            }
        }

        $bind = array(
            'code' => $code,
            'errors' => $errors,
            'verifyUrl' => $verifyUrl
        );
        END:
        $this->render($bind);
    }

    public function actionAjaxRegister(){
        #input
        $FUser = $_POST;
        #start
        $MUser = new MUser('register');
        $MUser->ip = Y::getIp();
        $MUser->attributes = $FUser;
        $errors = array();
        $verifyUrl = null;
        $session = Yii::app()->session;
        if($MUser->save()){
            $MUser = new MUser('login');
            $MUser->attributes = $FUser;
            $MUser->login();
            $code = 1;
            $session['login_error_time']=0;
        }else{
            $code = 2;
            $flag = intval(@$session['login_error_time'])>=S::MAX_LOGIN_ERROR_TIME;
            if(intval(@$session['login_error_time'])){
                $session['login_error_time'] += 1;
            } else {
                $session['login_error_time']=1;
            }
            $errors = $MUser->getErrors();
            if(!$flag && intval($session['login_error_time'])>=S::MAX_LOGIN_ERROR_TIME){
                $code = 3;
                $verifyUrl = $this->url($this->getId(),'captcha').'/v/'.mt_rand();
            }
        }
        END:
        $bind = array(
            'code' => $code,
            'errors' => $errors,
            'verifyUrl' => $verifyUrl
        );
        $this->render($bind);
    }

    public function actionAjaxLogout(){
        #input

        #start
        Yii::app()->user->logout();
        $code = 1;
        END:
        $bind = array(
            'code' => $code,
        );
        $this->render($bind);
    }
    
}
