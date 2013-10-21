<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $params = array(
            'test'=>Yii::app()->user->isGuest,
        );

        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind, S::DEV_USE_TEMPLATE,
            array('test_template'),//公用子模板
            array('main_partials_1')//局部子模板
        );
    }
}
