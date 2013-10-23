<?php
class CommentController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $user = $this->getUser();

        // $info = Company::create(array(
        //     'name'=>'再测试名字',
        //     'openedTime'=>date('Y-m-d'),
        // ));
        // $info = Comment::model()->find(array(
        //     'select'=>'recordTime',
        //     'condition'=>':userId=:userId and CompanyId=:companyId',
        //     'params'=>array(':userId'=>1,':companyId'=>1),
        //     'order'=>'id desc',
        //     'limit'=>1,
        //     ));


        // $info = Company::updateByIds(array(1,2),array('deleteFlag'=>0));
        // $info = Company::deleteByIds(array(1,2),array('category'=>'test'));
        // $info = Company::getList('id','1=1','id desc');
        // $info = Company::getListByPage('id', '1=1', '', array(), 1, 2, false);
         // foreach(Company::getList('*','id=1') as $m){
         //    $m->addCommentCount();
         // }
        
        // $info = Comment::create(array(
        //     'companyId'=>1,
        //     'userId'=>$user->id,
        //     'username'=>$user->username,
        //     'content'=>'测试评论内容',
        //     'totalScore'=>5,
        //     'scoreA'=>1,
        //     'scoreB'=>2,
        //     'scoreC'=>3,
        // ));
        // $info = Comment::deleteByIds(array(1,2));
        // $info = Comment::getList('id','1=1','id desc');
        // $info = Comment::getListByPage('id', '1=1', '', array(), 1, 2, false);
        //  foreach(Comment::getList('*','id=1') as $m){
        //     $m->addCommentCount();
        //  }

        print_r($info);
        die;

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
