<?php
class CompanyController extends Controller
{
    public function actionIndex(){
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $conditon = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $conditon .= 'and '.implode(' and ', $l);
        }
        $order = '';
        $orders = array('weight'=>'desc');//默认按权重排序
        if($order_str){
            $l = array();
            foreach(Y::xexplode(',', $order_str) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' '.$a[1];
                $orders[$a[0]] = $a[1];
            }
            $order .= implode(' , ', $l);
        }
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
