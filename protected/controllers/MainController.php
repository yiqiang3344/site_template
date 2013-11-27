<?php
class MainController extends Controller
{
    public function actionIndex(){
        #input

        #start
        $params = array('test'=>'yyy');
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index', $bind);
    }
}
