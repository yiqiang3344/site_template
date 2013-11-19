<?php

class MainController extends Controller{
    public function actionIndex() {
        #input
        $post = $_POST;
        #start

        $params = array(
            'logo_url'=>$this->siteUrl('img/logo.png'),
            'links' => Link::getListBySort(),
            'contacts' => Contact::getListBySort(),
        );
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('index',$bind);
    }

    public function actionCompanyList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $conditon = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $conditon .= implode(' and ', $l);
        }
        $order = '';
        $orders = array();
        if($order_str){
            $l = array();
            foreach(Y::xexplode(',', $order_str) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' '.$a[1];
                $orders[$a[0]] = $a[1];
            }
            $order .= implode(' , ', $l);
        }
        // echo $order;die;
        $select = 'id,category,name,nameFirstLetter,weight,hasLogo,star,score,beFixed,beRecommend,beGuarantee,clickCount,COMMENTCount,platform,hasLicense,openedTime,url,hasUrlPhoto,abstract,deleteFlag';
        $params =  Company::getListByPage($select, $conditon, $order, $params, $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('company-list',$bind);
    }

    public function actionCompanyEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $info = array();
        if($id){
            $info = Y::modelsToArray(Company::model()->findByPk($id));
        }

        $params = array();
        foreach(array('id','category','name','nameFirstLetter','weight','hasLogo','star','score','beFixed','beRecommend','beGuarantee','clickCount','commentCount','platform','hasLicense','openedTime','url','hasUrlPhoto','abstract','description','deleteFlag') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('company-edit',$bind);
    }

    public function actionContactEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $info = array();
        if($id){
            $info = Y::modelsToArray(Contact::model()->findByPk($id));
        }

        $params = array(
            'id'=>@$info['id'],
            'name'=>@$info['name'],
            'urlName'=>@$info['urlName'],
            'content'=>@$info['content'],
            'sort'=>@$info['sort']?$info['sort']:0,
        );
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('contact-edit',$bind);
    }

    ########################AJAX########################
    public function actionAjaxEditOne() {
        #input
        $type = ucwords($_POST['type']);
        $id = $_POST['id'];
        $attr = $_POST['attr'];
        $val = $_POST['val'];
        #start
        $code = 1;
        $error = '';

        $m = $type::model()->findByPk($id);
        $m->$attr = $val;
        if(!$m->save()){
            $code = 2;
            $errors = $m->getErrors();
        }

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxAdd() {
        #input
        $type = ucwords($_POST['type']);
        $id = @$_POST['id'];
        $info = $_POST;
        #start
        if($id){
            $map = array(
                'Contact'=>array('name','urlName','sort','content'),
                'Company'=>array('category','name','nameFirstLetter','weight','hasLogo','star','score','beFixed','beRecommend','beGuarantee','clickCount','commentCount','platform','hasLicense','openedTime','url','hasUrlPhoto','abstract','description','deleteFlag'),
            );

            $m = $type::model()->findByPk($id);
            foreach($map[$type] as $v){
                $m->$v = $info[$v];
            }
        }else{
            $m = new $type;
            $m->attributes = $info;
        }
        $code = 1;
        $error = '';

        if(!$m->save()){
            $code = 2;
            $errors = $m->getErrors();
        }

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxDelete() {
        #input
        $type = ucwords($_POST['type']);
        $ids = $_POST['ids'];
        #start
        $type::deleteByIds(explode(',',$ids));
        $code = 1;
        $error = '';

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
