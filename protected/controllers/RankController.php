<?php
class RankController extends Controller
{
    public function actionIndex(){
        #input
        $key = @$_GET['key']?$_GET['key']:'clickCount';//排序
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $condition = '';
        $sortMap = array('clickCount'=>'访问量','commentCount'=>'评论数','score'=>'评分','star'=>'星级');
        if(isset($sortMap[$key])){
            $order = $key.' desc,weight desc';
        }else{
            Y::end('illegal access.');
        }
        $params = array();
        $select = 'id,logo,name,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,abstract';
        $params = MCompany::getListByPage($select, $condition, $order, $params, $page, A::PAGE_SIZE, false);
        foreach($params['data'] as &$row){
            $row['goto'] = $this->url('Company','Go',array('to'=>$row['id']));
        }

        //排序方式
        $sorts = array();
        foreach($sortMap as $k=>$v){
            $sorts[] = array(
                'name'=>$v,
                'attr'=>$k,
                'url'=>$this->url('Rank','Index',array('key'=>$k)),
                'on'=>$k==$key?true:false
            );
        }
        $params['sorts'] = $sorts;

        $stageName = $sortMap[$key].'排行';
        END:
        $this->setStageList($stageName);
        $bind = array(
            'key' => $key,
            'params' => $params,
        );
        $this->render('index', $bind);
    }
}
