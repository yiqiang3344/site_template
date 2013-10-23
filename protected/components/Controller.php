<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {
    /**
     *
     * @var string the default layout for the controller view. Defaults to
     *      '//layouts/column1',
     *      meaning using a single column layout. See
     *      'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';
    /**
     *
     * @var array context menu items. This property will be assigned to {@link
     *      CMenu::items}.
     */
    public $menu = array ();
    /**
     *
     * @var array the breadcrumbs of the current page. The value of this
     *      property will
     *      be assigned to {@link CBreadcrumbs::links}. Please refer to {@link
     *      CBreadcrumbs::links}
     *      for more details on how to specify this property.
     */
    public $breadcrumbs = array ();

    public function filters() {
        return array (
        );
    }

    /**
     * Display view or return Ajax data
     *
     * @param array $data
     * @param string $view Template name
     * @return void
     */
    public $template;
    public $publicSubTemplate = array();//公用子模板
    public $partialsSubTemplate = array();//局部子模板
    public function render( $view='',$data=array(), $template_flag=S::DEV_USE_TEMPLATE,$publicSubTemplate=array(),$partialsSubTemplate=array()){
        if(is_array($view)) {
            $output =  json_encode($view);
        }else {
            //DEV_USE_TEMPLATE 表示开发时使用传入的模板，发布后使用已编译的js文件; USE_TEMPLATE 表示绝对会传入模板，用于php渲染; NOT_USE_TEMPLATE和其他 表示不用模板
            if($template_flag==S::USE_TEMPLATE){
                $this->template = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/'.$view.'.php',null,true);
                //读取子模板 非dev时，子模板已被编译为js方法， 局部子模板的js文件会在layouts的模板view中加载
                $t = array();
                foreach($publicSubTemplate as $v){
                    $t[$v] = $this->renderFile(Yii::app()->language.'/template/public_sub_template/_'.$v.'.php',null,true);
                }
                $this->publicSubTemplate = $t;
                $t = array();
                foreach($partialsSubTemplate as $v){
                    $t[$v] = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/_'.$v.'.php',null,true);
                }
                $this->partialsSubTemplate = $t;
            }elseif($template_flag==S::DEV_USE_TEMPLATE){
                if(Yii::app()->language=='dev'){
                    $this->template = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/'.$view.'.php',null,true);
                    //读取子模板 非dev时，子模板已被编译为js方法， 局部子模板的js文件会在layouts的模板view中加载
                    $t = array();
                    foreach($publicSubTemplate as $v){
                        $t[$v] = $this->renderFile(Yii::app()->language.'/template/public_sub_template/_'.$v.'.php',null,true);
                    }
                    $this->publicSubTemplate = $t;
                    $t = array();
                    foreach($partialsSubTemplate as $v){
                        $t[$v] = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/_'.$v.'.php',null,true);
                    }
                    $this->partialsSubTemplate = $t;
                }else{
                    $this->partialsSubTemplate = $partialsSubTemplate;
                }
            }
            $output =  parent::render($view,$data,true);
        }
        echo $output;
    }

    public function url($c,$a=null,$p=array()){
        if($a){
            $ret = Yii::app()->getBaseUrl().'/index.php/'.$c.'/'.$a.($p?'?':'');
            foreach($p as $k=>$v){
                $ret .= urlencode ( $k ) . "=" . urlencode ( $v ) . "&";
            }
        }else{
            //非开发环境中的css和js都是压缩过的,开发环境中则不压缩
            $not_translate = preg_match('{^(js/(jquery|main|url)\.|css)}',$c);
            if(Yii::app()->language=='dev'){
                if(!$not_translate){
                    //开发语言中需要翻译的
                    $c = Yii::app()->language.'/'.$c;
                }
            }else{
                $min_name = str_replace(array('.js','.css'),array('.min.js','.min.css'),$c);
                if($not_translate){
                    //非开发语言中不需要翻译的
                    $c = 'script/'.basename($min_name);
                }else{
                    //非开发语言中需要翻译的
                    $c = Yii::app()->language.'/'.$min_name;
                }
            }
            $md5 = @md5_file ($c);
            $ret = Yii::app()->getBaseUrl().'/'.$c.($md5 ? '?v=' . substr ( $md5, 0, 8 ) : '');
        }
        return $ret;
    }

    public function actions(){
        return array( 
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF, 
                'maxLength'=>'6',       // 最多生成几个字符
                'minLength'=>'5',       // 最少生成几个字符
                'height'=>'40',
                'width'=>'230',
            ), 
            'register'=>array(
                'class'=>'RegisterAction',
            ),
            'login'=>array(
                'class'=>'LoginAction',
            ),
            'logout'=>array(
                'class'=>'LogoutAction',
            ),
        ); 
        
    }

    public function accessRules(){
        return array(
            array('allow',
                'actions'=>array(
                    'captcha',
                    'register',
                    'login',
                    'logout',
                ),
                'users'=>array('*'),
            ),
        );
    }

    public function getUser(){
        if(Yii::app()->user->isGuest){
            Y::end(Yii::t('sys','no login'));
        }else{
            $user = User::model()->find('username=:username',array(':username'=>Yii::app()->user->getId()));
            return $user;
        }
    }

    public function getUD(){
        $info = array();
        $info['login_error_time'] = intval(Yii::app()->session['login_error_time']);
        $info['max_login_error_time'] = S::MAX_LOGIN_ERROR_TIME;
        if(Yii::app()->user->isGuest){
            $info['user'] = false;
        }else{
            $user = Y::cp($this->getUser(),array('id','username'));
            $info['user'] = $user;
        }
        return $info;
    }
}
