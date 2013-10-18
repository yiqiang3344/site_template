<?php 
class AreaController extends Controller {
    public function actionIndex(){
        $model = new AreaReport();
        $data = $model->getAreaInfo();
        $this->render('area', array('data'=>$data));
    }
}
?>
