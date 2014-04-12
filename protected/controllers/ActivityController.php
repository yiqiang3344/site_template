<?php
class ActivityController extends Controller
{
    public function actionIndex(){
        #input
        $order_str = @$_GET['order'] ? $_GET['order'] : 'recordTime:desc,img:desc';//排序 type1:sc1,type2:sc2
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $order = '';
        $orders = $l = array();
        foreach(Y::xexplode(',', $order_str) as $v){
            $a = explode(':', $v);
            $l[] = $a[0].' '.$a[1];
            $orders[$a[0]] = $a[1];
        }
        $order .= implode(' , ', $l);
        
        $condition = '';
        $params = array();
        $select = 'id,title,abstract,isEnd,img';
        $params = MActivity::getListByPage($select, $condition, $order, $params, $page, A::PAGE_SIZE, false);
        foreach($params['data'] as &$row){
            $row['url'] = $this->url('Activity','Go',array('to'=>$row['id']));
        }
        $params['homeUrl'] = Y::getUrl('Home','Index');
        $params['activityUrl'] = Y::getUrl('Activity','Index');
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }

    public function actionGo(){
        #input
        $id = $_GET['to'];
        #start
        $params = Y::modelsToArray(MActivity::model()->findByPk($id));
        $params['homeUrl'] = Y::getUrl('Home','Index');
        $params['activityUrl'] = Y::getUrl('Activity','Index');
        $params['dateTime'] = date('Y-m-d',$params['recordTime']);

        $stageName = $params['title'];
        END:
        $this->setStageList($stageName);
        $bind = array(
            'params' => $params,
        );
        $this->render('go', $bind);
    }
}
