<?php

class MainController extends Controller{
    public function actionIndex() {
        #input
        $post = $_POST;
        #start

        $params = array(
            'logo_url'=>$this->siteUrl('img/logo.png'),
            'links' => Link::getListBySort()
        );
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index',$bind);
    }

    ########################AJAX########################
    public function actionAjaxDeleteLink() {
        #input
        $ids = $_POST['ids'];
        #start
        Link::deleteByIds(explode(',',$ids));
        $code = 1;
        $error = '';

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxAddLink() {
        #input
        $linkInfo = $_POST;
        #start
        $Link = new Link;
        $Link->attributes = $linkInfo;
        $code = 1;
        $error = '';

        if(!$Link->save()){
            $code = 2;
            $errors = $Link->getErrors();
        }

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxUploadImage(){
        $type = 'logo';
        //上传配置
        $config = array(
            'savePath' => 'upload/',
            'maxSize' => 1000, //单位KB
            'allowFiles' => array('.gif', '.png', '.jpg')
        );

        if($type=='logo'){
            $config['savePath'] = 'img/';
            $config['name'] = 'logo';
            $config['setDir'] = true;
            $config['allowFiles'] = array('.png', '.jpg');
        }

        //生成上传实例对象并完成上传
        $up = new Uploader('file', $config);

        $info = $up->getFileInfo();

        $code = 1;
        $error = $info['state'];
        if($error!='SUCCESS'){
            $code = 2;
        }

        $this->render(array(
            'code' => $code,
            'error' => $error
        ));
    }
}
