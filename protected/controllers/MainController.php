<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $params = array(
            'test'=>Yii::app()->user->isGuest?'没登陆':'已经登陆',
        );

        // $info = Company::create(array(
        //     'name'=>'再测试名字',
        //     'openedTime'=>date('Y-m-d'),
        // ));

        // $info = Company::updateByIds(array(1,2),array('deleteFlag'=>0));
        // $info = Company::deleteByIds(array(1,2),array('category'=>'test'));
        // $info = Company::getList('id','1=1','id desc');
        // $info = Company::getListByPage('id', '1=1', '', array(), 1, 2, false);
         // foreach(Company::getList('*','id=1') as $m){
         //    $m->addCommentCount();
         // }

        print_r($info);

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
