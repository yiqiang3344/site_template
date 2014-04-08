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

    public function init() {
        $this->setStageList();
    }

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
    public $Mustache;
    public $template;
    public $publicSubTemplate = array();//公用子模板
    public $partialsSubTemplate = array();//局部子模板
    public $template_flag = false;//局部子模板
    public function render( $view='',$data=array(), $template_flag=S::USE_TEMPLATE,$usePartials=true,$usePublic=true){
        if(is_array($view)) {
            $output =  json_encode($view);
        }else {
            $this->template_flag = $template_flag;
            //DEV_USE_TEMPLATE 表示开发时使用传入的模板，发布后使用已编译的js文件; USE_TEMPLATE 表示绝对会传入模板，用于php渲染; NOT_USE_TEMPLATE和其他 表示不用模板
            if($template_flag==S::USE_TEMPLATE){
                $this->Mustache = new Mustache_Engine();
                $this->template = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/'.$view.'.php',null,true);
                //读取子模板
                if($usePartials){
                    $this->partialsSubTemplate = $this->getSubTemplateMap(Yii::app()->language.'/template/'.$this->getId());
                }
                if($usePublic){
                    $this->publicSubTemplate = $this->getSubTemplateMap(Yii::app()->language.'/template/public_sub_template');
                }
            }elseif($template_flag==S::DEV_USE_TEMPLATE){
                if(Yii::app()->language=='dev'){
                    $this->template = $this->renderFile(Yii::app()->language.'/template/'.$this->getId().'/'.$view.'.php',null,true);
                    //读取子模板 非dev时，子模板已被编译为js方法， 局部子模板的js文件会在layouts的模板view中加载
                    if($usePartials){
                        $this->partialsSubTemplate = $this->getSubTemplateMap('dev/template/'.$this->getId());
                    }
                    if($usePublic){
                        $this->publicSubTemplate = $this->getSubTemplateMap('dev/template/public_sub_template');
                    }
                }else{
                    $this->partialsSubTemplate = $usePartials;
                    $this->publicSubTemplate = $usePublic;
                }
            }
            $output =  parent::render($view,$data,true);
        }
        echo $output;
    }

    private function getSubTemplateMap($dir){
        $a = array();
        foreach(scandir($dir) as $file){
            if(is_file($dir.'/'.$file) && strpos($file,'_')===0){
                $name = '';
                foreach(explode('_',basename($file,'.php')) as $v){
                    $name .= ucfirst($v);
                }
                $name = lcfirst($name);
                $a[$name] = $this->renderFile($dir.'/'.$file,null,true);
            }
        }
        return $a;
    }

    public function url($c,$a=null,$p=array()){
        return Y::getUrl($c,$a,$p);
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
            // 'register'=>array(
            //     'class'=>'RegisterAction',
            // ),
            // 'login'=>array(
            //     'class'=>'LoginAction',
            // ),
            // 'logout'=>array(
            //     'class'=>'LogoutAction',
            // ),
        ); 
        
    }

    public function accessRules(){
        return array(
            array('allow',
                'actions'=>array(
                    'captcha',
                    // 'register',
                    // 'login',
                    // 'logout',
                ),
                'users'=>array('*'),
            ),
        );
    }

    public function checkUser(){
        return $this->getUser()?true:false;
    }

    public function getUser(){
        return MUser::model()->find('username=:username',array(':username'=>Yii::app()->user->getId()));
    }

    public function getUD(){
        $info = array();
        $info['login_error_time'] = intval(Yii::app()->session['login_error_time']);
        $info['max_login_error_time'] = S::MAX_LOGIN_ERROR_TIME;
        $user = $this->getUser();
        $info['user'] = $user?Y::cp($user,array('id','username')):false;
        return $info;
    }

    public function getHeaderParams(){
        $user = $this->getUser();
        $params = array(
            'logo' => $this->url('img/logo.png'),
            'searchUrl' => $this->url('Search','Index'),
            'loginUrl' => $this->url('Site','Login'),
            'registerUrl' => $this->url('Site','Register'),
            'user' => $user?true:false,
            'username' => $user?$user->username:null,
            'navList' => array(
                array(
                    'on'=>$this->id=='main',
                    'name'=>'首页',
                    'url'=>$this->url('Main','Index'),
                ),
                array(
                    'on'=>$this->id=='activity',
                    'name'=>'活动',
                    'url'=>$this->url('Activity','Index'),
                ),
                array(
                    'on'=>$this->id=='information',
                    'name'=>'资讯',
                    'url'=>$this->url('Information','Index'),
                ),
                array(
                    'on'=>$this->id=='company',
                    'name'=>'公司大全',
                    'url'=>$this->url('Company','Index'),
                ),
                array(
                    'on'=>$this->id=='rank',
                    'name'=>'排行榜',
                    'url'=>$this->url('Rank','Index',array('key'=>'clickCount')),
                ),
            ),
            'stageList'=>$this->stateList,
            'topAd'=>$this->id!='main'?false:Y::modelsToArray(MAd::model()->find(array('condition'=>'deleteFlag=0 and category=:category','params'=>array(':category'=>'top'),'order'=>'sort asc'))),
            'sliderBanner'=> $this->id=='main' && ($list = Y::modelsToArray(MAd::model()->findAll(array('condition'=>'deleteFlag=0 and category=:category','params'=>array(':category'=>'slide'),'order'=>'sort asc')))) ? array('list'=>$list ) : false
        );
        foreach(MLink::model()->getListBySort() as $row){
            $params['navList'][] = array(
                'name'=>$row['name'],
                'url'=>$row['url'],
            );
        }
        return $params;
    }

    public function getFooterParams(){
        $params = array(
            'list' => array()
        );
        $sublist = array();
        $list = MContact::model()->getListBySort();
        $c = count($list);
        foreach(MContact::model()->getListBySort() as $k => $row){
            $sublist[] = array(
                'name'=>$row['name'],
                'url'=>$this->url('Contact','Go',array('to'=>$row['urlName'])),
            );
            if($k==$c-1 or ($k!=0 && ($k+1)%5==0)){
                $params['list'][] = $sublist;
                $sublist = array();
            }
        }
        return $params;
    }

    public $stateList;
    public function setStageList($subStateName=false) {
        if(!$this->stateList){
            $map = array(
                'company'=>array(
                    'name'=> '公司大全',
                    'url'=> $this->url('Company','Index'),
                ),
                'information'=>array(
                    'name'=> '资讯',
                    'url'=> $this->url('Information','Index'),
                ),
                'activity'=>array(
                    'name'=> '活动',
                    'url'=> $this->url('Activity','Index'),
                ),
                'rank'=>array(
                    'name'=> '排行榜',
                    'url'=> $this->url('Rank','Index'),
                ),
                'search'=>array(
                    'name'=> '搜索',
                    'url'=> $this->url('Search','Index'),
                ),
            );
            $this->stateList = array(
                array(
                    'name'=>'首页',
                    'url'=>$this->url('Main','Index'),
                    'first'=>true,
                )
            );
            if(isset($map[$this->getId()])){
                $this->stateList[] = $map[$this->getId()];
            }
        }
        if($subStateName){
            $this->stateList[] = array(
                'name'=>$subStateName,
                'url'=>false
            );
        }
    }

}
