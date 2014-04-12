<?php
class CompanyController extends Controller
{
    public function actionIndex(){
        #input
        $search = @$_GET['search'];//搜索 [属性]-[值]_...
        $order_str = @$_GET['order'];//排序 [属性]-[顺序]_...
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $condition = '';
        $searchs = array();
        if($search && strpos($search,'-')){
            $l = array();
            foreach(Y::xexplode('_', $search) as $v){
                $a = explode('-', $v);
                $searchs[$a[0]] = $a[1];
                if($a[0]=='nameFirstLetter'){
                    $l[] = '('.$a[0].' like \''.$a[1].'\''.' or '.$a[0].' like \''.strtolower($a[1]).'\''.')';//暂时需要全匹配，针对首字母检索，忽略大小写
                }else{
                    $l[] = $a[0].' like \''.$a[1].'\'';
                }
            }
            $condition .= implode(' and ', $l);
        }
        $order = 'weight desc';
        $orders = array();//默认按权重排序
        if($order_str && strpos($order_str,'-')){
            $l = array();
            foreach(Y::xexplode('_', $order_str) as $v){
                $a = explode('-', $v);
                $l[] = $a[0].' '.$a[1];
                $orders[$a[0]] = $a[1];
            }
            $order .= ','.implode(' , ', $l);
        }
        $params = array();
        $select = 'id,logo,name,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,abstract';
        $params = MCompany::getListByPage($select, $condition, $order, $params, $page, A::PAGE_SIZE, false);
        foreach($params['data'] as &$row){
            $row['goto'] = $this->url('Company','Go',array('to'=>$row['id']));
        }

        //大分类
        $categorys = array();
        foreach(MCompany::getCategorys() as $m){
            $categorys[] = array(
                'name'=>$m->category,
                'url'=>$this->url('Company','Index',array('search'=>'category-'.$m->category.(@$searchs['nameFirstLetter'] ? ('_nameFirstLetter-'.$searchs['nameFirstLetter']) : '')))
            );
        }
        $params['categorys'] = $categorys;

        //字母分类
        $letters = array();
        for($v='A';;$v++){
            $letters[] = array(
                'name'=>$v,
                'url'=>$this->url('Company','Index',array('search'=>'nameFirstLetter-'.$v.(@$searchs['category'] ? ('_category-'.$searchs['category']) : '')))
            );
            if($v==='Z'){
                break;
            }
        }
        $params['letters'] = $letters;

        //排序方式
        $sorts = array(
            array(
                'name'=>'星级',
                'attr'=>'star',
                'desc'=>@$orders['star']&&$orders['star']=='desc',
                'asc'=>@$orders['star']&&$orders['star']=='asc'
            ),
            array(
                'name'=>'评分',
                'attr'=>'score',
                'desc'=>@$orders['score']&&$orders['score']=='desc',
                'asc'=>@$orders['score']&&$orders['score']=='asc'
            ),
            array(
                'name'=>'访问量',
                'attr'=>'clickCount',
                'desc'=>@$orders['clickCount']&&$orders['clickCount']=='desc',
                'asc'=>@$orders['clickCount']&&$orders['clickCount']=='asc'
            ),
            array(
                'name'=>'评论量',
                'attr'=>'commentCount',
                'desc'=>@$orders['commentCount']&&$orders['commentCount']=='desc',
                'asc'=>@$orders['commentCount']&&$orders['commentCount']=='asc'
            ),
        );
        $params['sorts'] = $sorts;

        $bind = array(
            'search' => $search,
            'order' => $order_str,
            'params' => $params,
        );
        $this->render('index', $bind);
    }

    public function actionGo(){
        #input
        $id = $_GET['to'];
        $search = @$_GET['search'];//搜索 [属性]-[值]_...
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        if(!$id || !($company=MCompany::model()->findByPk($id))){
            Y::end('illegal Access.');
        }

        $params = Y::modelsToArray($company);

        $condition = 'companyId='.$id;
        $searchs = array();
        if($search && strpos($search,'-')){
            $l = array();
            foreach(Y::xexplode('_', $search) as $v){
                $a = explode('-', $v);
                $searchs[$a[0]] = $a[1];
                $l[] = $a[0].'='.$a[1];
            }
            $condition .= ' and '.implode(' and ', $l);
        }
        $order = 'id desc';
        $select = 'userId, username, content, totalScore, scoreA, scoreB, scoreC, recordTime';
        $comments = MComment::getListByPage($select, $condition, $order, array(), $page, A::PAGE_SIZE, false, false);
        $scoreToStrMap = array(
            1=>'较差',
            2=>'一般',
            3=>'不错',
            4=>'良好',
            5=>'很好',
        );
        foreach($comments['data'] as &$row){
            $row['aStr'] = $scoreToStrMap[$row['scoreA']];
            $row['bStr'] = $scoreToStrMap[$row['scoreB']];
            $row['cStr'] = $scoreToStrMap[$row['scoreC']];
            $row['dateTime'] = date('Y-m-d',$row['recordTime']);
        }
        $params['comments'] = $comments;

        $commentUrls = array(
            array(
                'name'=> '全部',
                'url'=> $this->url('Company','Go',array('to'=>$id)),
                'num'=> $params['commentCount']
            )
        );
        foreach(array(5,4,3,2,1) as $v){
            $commentUrls[] = array(
                'name'=> $v.'星',
                'url'=> $this->url('Company','Go',array('to'=>$id,'search'=>'totalScore-'.$v)),
                'num'=> MComment::model()->count('companyId=:companyId and totalScore=:totalScore',array(':companyId'=>$id,':totalScore'=>$v))
            );
        }
        $params['commentUrls'] = $commentUrls;
        $params['homeUrl'] = Y::getUrl('Home','Index');
        $params['companyUrl'] = Y::getUrl('Company','Index');

        $stageName = $params['name'];
        END:
        $this->setStageList($stageName);
        $bind = array(
            'params' => $params,
            'companyId' => $id,
        );
        $this->render('go', $bind);
    }

    public function actionAjaxAddComment(){
        #input
        $post = $_POST;
        #start
        if($this->checkUser()){
            $user = $this->getUser();
            $code = 1;
            $errors = '';
            if($post){
                Y::begin();
                $m = new MComment('create');
                $post['userId'] = $user->id;
                $post['username'] = $user->username;
                $m->attributes = $post;
                if(!$m->save()){
                    $code = 2;
                    $errors = $m->getErrors();
                    Y::rollback();
                }else{
                    Y::commit();
                }
            }else{
                $code = 2;
                $errors = array(array('illegal submit.'));
            }
        }else{
            $code = 2;
            $errors = array(array('请先登陆。'));
        }

        END:
        $bind = array(
            'code' => $code,
            'errors' => $errors
        );
        $this->render($bind);
    }

    public function actionAjaxAddClickCount(){
        #input
        $id = $_POST['id'];
        #start
        //访问数加1
        $id && MCompany::model()->updateCounters(array('clickCount'=>1),'id=:id',array(':id'=>$id));

        $code = 1;
        $errors = array();
        END:
        $bind = array(
            'code' => $code,
            'errors' => $errors
        );
        $this->render($bind);
    }
}
