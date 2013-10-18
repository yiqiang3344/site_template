<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='/layouts/column1';
	 
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	
	public $isAjax = false;
    
    /**
     * Display view or return Ajax data
     * 
     * @param array $data 
     * @param string $view Template name
     * @return void
     */
    protected function display( $view='',$data=array() ){
 	
        if( !empty($view) ) {
    	
           $output = $this->render($view,$data,true);
        }
        else {
            $output = $data ;
        }
        
        if( $this->isAjax ){
            $this->echoJsonData( $output );
        }
        else {
            echo $output ;
        }
    }
    
    /**
     * return error message to content.
     * 
     * @param string $message
     * @param integer $stateCode
     * @param mixed $data
     * @return void
     */
    protected function error( $message='System error', $stateCode=-1, $data=array() ){
        if( $this->isAjax ){
            $this->echoJsonData( $data, $stateCode, $message );
        }
        else {
            $this->renderText($message);
            Yii::app()->end();
        }
    }
    
    /**
     * Controller::success()
     * 
     * @param mixed $message
     * @param string $jsAction
     * @return void
     */
    protected function success($message,$jsAction=''){
        if( $this->isAjax ){
            $this->echoJsonData( $jsAction, 2, $message );
        }
        else {
            $this->renderText($message);
        }
    }
    
    /**
     * echo json data
     * 
     * @param array $data
     * @param integer $stateCode
     * @param string $message
     * @return void
     */
    protected function echoJsonData($data=array(), $stateCode=1, $message='success'){
            $result = array(
                'stateCode' => $stateCode ,
                'message'   => $message , 
                'data'      => $data 
            );
            
            
            echo json_encode($result);
            Yii::app()->end();
    }
}
