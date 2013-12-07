<?php
class InformationController extends Controller
{
    public function actionIndex(){
        #input
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $order = '';
        $orders = array('recordTime'=>'desc','img'=>'desc');
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
        $select = 'id,title,abstract,img';
        $params = Information::getListByPage($select, $condition, $order, $params, $page, 20, false);
        foreach($params['data'] as &$row){
            $row['url'] = $this->url('Information','Go',array('to'=>$row['id']));
        }
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }

    public function actionGo(){
        #input
        $id = $_GET['to'];
        #start
        $params = Y::modelsToArray(Information::model()->findByPk($id));

        $stageName = $params['title'];
        END:
        $this->setStageList($stageName);
        $bind = array(
            'params' => $params,
        );
        $this->render('go', $bind);
    }
}
