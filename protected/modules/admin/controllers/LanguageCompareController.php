<?php

class LanguageCompareController extends Controller{
    public $layout='/layouts/compare';
	public $messagePath;
    
    public function actionIndex() {
        $this->render('index');
		
    }

	public function actionCompareResult() {
		$this->messagePath = dirname(__FILE__).'/../../../messages/';
		$preLan = $_GET['preLan'];
		$nextLan = $_GET['nextLan'];
		$d = dir( $this->messagePath.$preLan );
		$result = array();
		while( $f=$d->read() ) {
			if( strpos($f,'.')===0 ) continue ;
			$msg = include($this->messagePath.$preLan.'/'.$f);
			$enData = include($this->messagePath.$nextLan.'/'.$f);
			foreach( $msg as $k=>$v ) {
				if( empty($enData[$k]) ) {
					$result[$f][$k] = $v ;
					//echo "\t$k\t".str_replace( array("\r","\n","\t"),"",$v)."\n";
				}
			}
		}
        $this->render('compareResult',array('result' => $result));
    }
}