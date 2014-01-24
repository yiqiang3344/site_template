<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $companys = Y::modelsToArray(MCompany::model()->findAll(array(
            'select'=>'id,logo,name,star',
            'condition'=>'deleteFlag=0 and beRecommend=1',
            'order'=>'weight desc',
            'limit'=> 24,
        )));


        $activities = Y::modelsToArray(MActivity::model()->findAll(array(
            'select'=>'id,img,title,abstract',
            'condition'=>'deleteFlag=0 and img!=""',
            'order'=>'id desc',
            'limit'=> 8,
        )));

        $informations = array();
        foreach(MInforCategory::model()->findAll(array('order'=>'sort asc')) as $m){
            $a = array();
            foreach(Y::modelsToArray(MInformation::model()->findAll(array(
                'select'=>'id,img,title,abstract',
                'condition'=>'categoryId=:categoryId and top=1 and deleteFlag=0',
                'order'=>'img desc,id desc',
                'limit'=> 7,
                'params'=> array(':categoryId'=>$m->id)
            ))) as $row){
                $row['url'] = $this->url('Information','Go',array('to'=>$row['id']));
                $a[] = $row;
            }
            $first = array_shift($a);
            $informations[] = array(
                'name'=>$m->title,
                'id'=>$first['id'],
                'img'=>$first['img'],
                'title'=>$first['title'],
                'abstract'=>$first['abstract'],
                'list'=>$a
            );
        }
        // var_dump($informations);die;

        $newCompanys = Y::modelsToArray(MCompany::model()->findAll(array(
            'select'=>'id,logo,name,star',
            'condition'=>'deleteFlag=0',
            'order'=>'id desc',
            'limit'=> 30,
        )));

        foreach($companys as &$row){
            $row['url'] = $this->url('Company','Go',array('to'=>$row['id']));
        }
        foreach($newCompanys as &$row){
            $row['url'] = $this->url('Company','Go',array('to'=>$row['id']));
        }
        foreach($activities as &$row){
            $row['url'] = $this->url('Activity','Go',array('to'=>$row['id']));
        }

        $params = array(
            'companys' => $companys,
            'activities' => $activities,
            'informations' => $informations,
            'newCompanys' => $newCompanys,
        );

        // var_dump($params);

        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }
}
