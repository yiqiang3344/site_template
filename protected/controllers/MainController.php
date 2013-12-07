<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $companys = Y::modelsToArray(Company::model()->findAll(array(
            'select'=>'id,logo,name,star',
            'condition'=>'deleteFlag=0 and beRecommend=1',
            'order'=>'weight desc',
            'limit'=> 20,
        )));


        $activities = Y::modelsToArray(Activity::model()->findAll(array(
            'select'=>'id,img,title,abstract',
            'condition'=>'deleteFlag=0 and img!=""',
            'order'=>'id desc',
            'limit'=> 8,
        )));

        $informations = Y::modelsToArray(Information::model()->findAll(array(
            'select'=>'id,img,title,abstract',
            'condition'=>'deleteFlag=0 and img!=""',
            'order'=>'id desc',
            'limit'=> 8,
        )));

        $newCompanys = Y::modelsToArray(Company::model()->findAll(array(
            'select'=>'id,logo,name,star',
            'condition'=>'deleteFlag=0',
            'order'=>'id desc',
            'limit'=> 20,
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
        foreach($informations as &$row){
            $row['url'] = $this->url('Information','Go',array('to'=>$row['id']));
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
