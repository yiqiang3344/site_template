<?php
class RankController extends Controller
{
    public function actionIndex(){
        #input
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $order = '';
        $orders = array('recordTime'=>'desc');
        if($order_str){
            $l = array();
            foreach(Y::xexplode(',', $order_str) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' '.$a[1];
                $orders[$a[0]] = $a[1];
            }
            $order .= implode(' , ', $l);
        }
        $condition = '';
        $params = array();
        $select = 'id,logo,name,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,abstract';
        $params = Company::getListByPage($select, $condition, $order, $params, $page, 20, false);
        foreach($params['data'] as &$row){
            $row['url'] = $this->url('Company','Go',array('to'=>$row['id']));
        }
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }
}
