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
    public $layout = 'main';
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

    public function init(){
    }

    public function filters() {
        return array (
            'checkLogin',
        );
    }

    public function filterCheckLogin($filterChain) {
        if(!in_array($this->getId(),array('site')) && Yii::app()->user->isGuest){
            $this->redirect($this->url('Site','Login'));
            return false;
        }
        $filterChain->run();
    }

    private $_basePath;
    public function getPath(){
        if(isset($this->_basePath)){
            return $this->_basePath;
        }
        $this->_basePath = $this->module->getBasePath();
        return $this->_basePath;
    }

    private $_assetsUrl;
    public function getAssetsUrl(){
        if(isset($this->_assetsUrl)){
            return $this->_assetsUrl;
        }
        $this->_assetsUrl = $this->module->getAssetsUrl();
        return $this->_assetsUrl;
    }

    /**
     * Display view or return Ajax data
     *
     * @param array $data
     * @param string $view Template name
     * @return void
     */
    public $template;
    public function render( $view='',$data=array(), $template_flag=S::USE_TEMPLATE){
        if(is_array($view)) {
            $output =  json_encode($view);
        }else {
            //DEV_USE_TEMPLATE 表示只有开发时才传入模板，因为发布后模板已编译到js文件中; USE_TEMPLATE 表示绝对会传入模板，用于php渲染; false 表示不用模板
            if($template_flag!=S::NOT_USE_TEMPLATE && ($template_flag==S::USE_TEMPLATE || ($template_flag==S::DEV_USE_TEMPLATE && Yii::app()->language=='dev'))){
                $this->template = $this->renderFile($this->getPath().'/template/'.$this->getId().'/'.$view.'.php',null,true);
            }
            $output =  parent::render($view,$data,true);
        }
        echo $output;
    }

    public function getBaseUrl(){
        return Yii::app()->getBaseUrl().'/index.php/'.$this->module->getName();
    }

    public function url($c,$a=null,$p=array()){
        if($a){
            $ret = $this->getBaseUrl().'/'.$c.'/'.$a.($p?'?':'');
            foreach($p as $k=>$v){
                $ret .= urlencode ( $k ) . "=" . urlencode ( $v ) . "&";
            }
        }else{
            $md5 = @md5_file ($this->getPath().'/'.$c);
            $ret = $this->getAssetsUrl().'/'.$c.($md5 ? '?v=' . substr ( $md5, 0, 8 ) : '');
        }
        return $ret;
    }

    

    public function siteUrl($c,$a=null,$p=array()){
        if($a){
            $ret = Yii::app()->getBaseUrl().'/index.php/'.$c.'/'.$a.($p?'?':'');
            foreach($p as $k=>$v){
                $ret .= urlencode ( $k ) . "=" . urlencode ( $v ) . "&";
            }
        }else{
            //非开发环境中的css和js都是压缩过的,开发环境中则不压缩
            $not_translate = preg_match('{^(js/(jquery|main|url)\.|css|img|images)}',$c);
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
}
