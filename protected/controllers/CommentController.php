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

        // $info = Information::create(array(
        //     'title'=>'活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动1活动12',
        //     'abstract'=>'简介1',
        //     'hasPicture'=>1,
        //     'content'=>'活动内容1',
        // ));
        // $info = Information::deleteByIds(array(1,2));
        // $info = Information::getList('id','1=1','id desc');
        // $info = Information::getListByPage('id', '1=1', '', array(), 1, 2, false);
        //  foreach(Information::getList('*','id=1') as $m){
        //     $m->addCommentCount();
        //  }

        // $info = Activity::create(array(
        //     'title'=>'活动1活动1活动1活动1活动1活动1活动1',
        //     'abstract'=>'简介1简介1简介1简介1简介1简介1简介1简介1',
        //     // 'hasPicture'=>1,
        //     'content'=>'活动内容1',
        // ));
        // $info = Activity::deleteByIds(array(1,2));
        // $info = Activity::getList('id','1=1','id desc');
        // $info = Activity::getListByPage('id', '1=1', '', array(), 1, 2, false);
        //  foreach(Activity::getList('*','id=1') as $m){
        //     $m->addCommentCount();
        //  }

        // $info  = Search::getCompanyListByName('名字');

        // $info = Contact::create(array(
        //     'urlName'=>'introduce1',
        //     'name'=>'自我介绍1',
        //     'content'=>'自我介绍内容',
        // ));
        // $info = Contact::getInfoByUrlName('introduce1');
        // $info = Contact::getListBySort();

        // $info = Link::create(array(
        //     'url'=>'url2',
        //     'name'=>'外链2',
        // ));
        // $info = Link::getListBySort();
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
