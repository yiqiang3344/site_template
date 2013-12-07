<?php

class MainController extends Controller{
    public function actionIndex() {
        #input
        $post = $_POST;
        #start
        $this->title = 'Index';

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

    public function actionLogout() {
        #input
        #start
        Yii::app()->user->logout();
        $this->redirect($this->url('Main','Index'));
    }

    public function actionBackup() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->checkSuperAdmin();
        $this->title = 'Backup';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= 'and '.implode(' and ', $l);
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
        $select = 'id,name,lastRebackTime,createTime';
        $params =  Backup::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        $params['now'] = date('Ymdhis',Y::getTime());
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );        
        $this->render('backup',$bind);
    }

    public function actionAdminList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->checkSuperAdmin();
        $this->title = 'Admin';
        $condition = 'super=0 ';//不能修改超级管理员
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= 'and '.implode(' and ', $l);
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
        $select = 'id,username,deleteFlag';
        $params =  Admin::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('admin-list',$bind);
    }

    public function actionAdminEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $this->checkSuperAdmin();
        $info = array();
        if($id){
            $info = Y::modelsToArray(Admin::model()->findByPk($id));
        }

        $params = array();
        foreach(array('id','username','password','passwordConfirm') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('admin-edit',$bind);
    }

    public function actionUserList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'User';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,username,deleteFlag';
        $params =  User::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('user-list',$bind);
    }

    public function actionLinkList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Link';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,name,url,sort,deleteFlag';
        $params =  Link::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('link-list',$bind);
    }

    public function actionContactList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Contact';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,name,urlName,sort,deleteFlag';
        $params =  Contact::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('contact-list',$bind);
    }

    public function actionContactEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $info = array();
        if($id){
            $info = Y::modelsToArray(Contact::model()->findByPk($id));
        }

        $params = array();
        foreach(array('id','name','urlName','content','sort','deleteFlag') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('contact-edit',$bind);
    }

    public function actionActivityList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Activity';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,title,abstract,img,deleteFlag';
        $params =  Activity::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('activity-list',$bind);
    }

    public function actionActivityEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $info = array();
        if($id){
            $info = Y::modelsToArray(Activity::model()->findByPk($id));
        }

        $params = array();
        foreach(array('id','title','abstract','img','content','deleteFlag') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('activity-edit',$bind);
    }

    public function actionCommentList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Comment';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id, companyId, userId, username, content, totalScore, scoreA, scoreB, scoreC, deleteFlag';
        $params =  Comment::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('comment-list',$bind);
    }

    public function actionInformationList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Information';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,title,abstract,img,deleteFlag';
        $params =  Information::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
        END:
        $bind = array(
            'params' => $params,
            'orders' => $orders
        );
        $this->render('information-list',$bind);
    }

    public function actionInformationEdit() {
        #input
        $id = @$_GET['id'];
        #start
        $info = array();
        if($id){
            $info = Y::modelsToArray(Information::model()->findByPk($id));
        }

        $params = array();
        foreach(array('id','title','abstract','img','content','deleteFlag') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('information-edit',$bind);
    }

    public function actionCompanyList() {
        #input
        $search = @$_GET['search'];//搜索 attr:val
        $order_str = @$_GET['order'];//排序 type1:sc1,type2:sc2
        $p = max(intval(@$_GET['p']),1);//分页
        #start
        $this->title = 'Company';
        $condition = '';
        if($search){
            $l = array();
            foreach(Y::xexplode(',', $search) as $v){
                $a = explode(':', $v);
                $l[] = $a[0].' like \'%'.$a[1].'%\'';
            }
            $condition .= implode(' and ', $l);
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
        $select = 'id,category,name,nameFirstLetter,weight,logo,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,platform,hasLicense,openedTime,url,urlPhoto,abstract,deleteFlag';
        $params =  Company::getListByPage($select, $condition, $order, array(), $p, 10, false, true);
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
        foreach(array('id','category','name','nameFirstLetter','weight','logo','star','score','beFixed','beRecommend','beGuarantee','clickCount','commentCount','platform','hasLicense','openedTime','url','urlPhoto','abstract','description','deleteFlag') as $v){
            $params[$v] = @$info[$v];
        }
        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('company-edit',$bind);
    }
    ########################AJAX########################
    public function actionAjaxBackup() {
        #input
        $form = $_POST;
        #start
        $code = 1;
        $errors = '';
        if(!$this->checkSuperAdmin(false)){
            Y::end('Illegal operation');
        }

        $m = new Backup;
        $m->attributes = $form;
        if(!$m->save()){
            $code = 2;
            $errors = $m->geterrors();
        }

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxReback() {
        #input
        $id = $_POST['id'];
        #start
        $code = 1;
        $errors = '';
        if(!$this->checkSuperAdmin(false)){
            Y::end('Illegal operation');
        }

        if($m = Backup::model()->findByPk($id)){
            list($code,$errors) = $m->reback();
        }else{
            $code = 2;
            $errors = '备份不存在！';
        }

        END:
        $this->render(array(
            'code' => $code,
            'errors' => $errors
        ));
    }

    public function actionAjaxEditOne() {
        #input
        $type = ucwords($_POST['type']);
        $id = $_POST['id'];
        $attr = $_POST['attr'];
        $val = $_POST['val'];
        #start
        $code = 1;
        $errors = '';

        if($type=='User' && !in_array($attr, array('deleteFlag'))){
            Y::end('Illegal operation.');
        }elseif($type=='Admin' && !in_array($attr, array('deleteFlag'))){
            Y::end('Illegal operation.');
        }elseif(in_array($type, array('Admin','Backup')) && !$this->checkSuperAdmin()){
            Y::end('Illegal operation.');
        }

        $m = $type::model()->findByPk($id);

        if($type=='Admin' && $m->super==1){
            Y::end('Illegal operation.');
        }

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
        if(in_array($type,array('Admin','Backup'))){
            if(!$this->checkSuperAdmin(false)){
                Y::end('Illegal operation');
            }
        }
        Y::begin();
        if($id){
            $map = array(
                'Contact'=>array('name','urlName','sort','content'),
                'Company'=>array('category','name','nameFirstLetter','weight','logo','star','score','beFixed','beRecommend','beGuarantee','clickCount','commentCount','platform','hasLicense','openedTime','url','urlPhoto','abstract','description','deleteFlag'),
                'Information'=>array('title','abstract','img','content','deleteFlag'),
                'Activity'=>array('title','abstract','img','content','deleteFlag'),
                'Admin'=>array('username','password','passwordConfirm'),
                'Backup'=>array('name'),
            );

            $m = $type::model()->findByPk($id);
            foreach($map[$type] as $v){
                $m->$v = $info[$v];
            }
        }else{
            $m = new $type('create');
            $m->attributes = $info;
        }

        $code = 1;
        $errors = '';
        if(!$m->save()){
            $code = 2;
            $errors = $m->getErrors();
        }else{
            //上传图片
            if($type=='Company'){
                $save = false;
                foreach($_FILES as $k=>$f){
                    $save = true;
                    $config = array(
                        'savePath' => 'upload/',
                        'name' => 'company_'.$k.'_'.$m->id,
                        'maxSize' => 2000, //单位KB
                        'allowFiles' => array('.gif', '.png', '.jpg')
                    );
                    //生成上传实例对象并完成上传
                    $up = new Uploader($k, $config);

                    $info = $up->getFileInfo();
                    if($info['state']!='SUCCESS'){
                        Y::rollback();
                        $code = 3;
                        $errors = $k.'上传失败!';
                        GOTO END;
                    }
                    $m->$k = $this->url($info['url']);
                }
                $save && $m->save();
            }
        }
        Y::commit();

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
        if(in_array($type,array('Admin','Backup'))){
            if(!$this->checkSuperAdmin(false)){
                Y::end('Illegal operation');
            }
        }

        $type::deleteByIds(explode(',',$ids));
        $code = 1;
        $errors = '';

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
