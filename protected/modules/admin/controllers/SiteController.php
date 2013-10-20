<?php

class SiteController extends Controller
{
    public function actionLogin(){
        #input
        $post = $_POST;
        #start
        if($post){
            $admin = new Admin('login');
            $admin->attributes = $post;
            if($admin->validate() && $admin->login()){
                $this->redirect($this->url('Main','Index'));
                Yii::app()->end();
            }else{
                print_r($post);
                echo Y::FUE('admin');
                print_r($admin->getErrors());
            }
        }
        $params = array(
            'action'=>$this->url('Site','Login'),
        );
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('login',$bind);
    }

    public function actionAjaxLogout(){
        #input
        $post = $_POST;
        #start
        $code = 1;
        $url = $this->url('Site','Login');
        Yii::app()->user->logout();
        END:
        $bind = array(
            'code' => $code,
            'url' => $url,
        );
        $this->render($bind);
    }

    public function actionError(){
        echo '##error!';
    }
}