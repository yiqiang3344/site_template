<?php
class SearchController extends Controller
{
    public function actionIndex(){
        #input
        $search = $_GET['search'];
        $page = max(intval(@$_GET['p']),1);//分页
        #start
        $params = Search::getCompanyListByName($search,$page,2);
        foreach($params['data'] as &$row){
            $row['goto'] = $this->url('Company','Go',array('to'=>$row['id']));
        }
        $params['search'] = $search;
        $params['searchUrl'] = $this->url('Search','Index');

        $stageName = $search;
        END:
        $this->setStageList($stageName);
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }
}
