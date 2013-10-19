<?php

class SiteController extends Controller
{
    public function actionLogin(){
        #input

        #start
        $params = array();
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('login',$bind);
    }

    public function actionError(){
        echo '##error!';
    }
}