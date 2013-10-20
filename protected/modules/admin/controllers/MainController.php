<?php

class MainController extends Controller{
    public function actionIndex() {
        #input
        $post = $_POST;
        #start
        $params = array(
        );
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index',$bind);
    }
}
