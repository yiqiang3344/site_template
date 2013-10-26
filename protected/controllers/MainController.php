<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $params = array(
            'test'=>Yii::app()->user->isGuest?'没登陆':'已经登陆',
        );

        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind, S::DEV_USE_TEMPLATE);
    }
}
