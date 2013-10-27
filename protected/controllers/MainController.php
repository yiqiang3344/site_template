<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        // $info = Company::create(array(
        //     'name'=>'再测试名字',
        //     'openedTime'=>date('Y-m-d'),
        // ));

        $info = Company::getListByPage('id', '', '', array(), 1, 1, false, true);
        // print_r($info);die;
        $params = array(
            'test'=>Yii::app()->user->isGuest?'没登陆':'已经登陆',
            'pager'=>$info,
        );


        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind, S::DEV_USE_TEMPLATE);
    }
}
