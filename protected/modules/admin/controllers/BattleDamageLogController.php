<?php

class BattleDamageLogController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions(){
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters(){
        return array(
            'CacheFlush',
        );
    }

	public function filterCacheFlush($filterChain){
//      Yii::app()->cache->flush();
        $filterChain->run();
        return true;

	}

	public function actionIndex(){
        $log = BattleDamageLog::displayLog(@$_GET['logId']);
        print_r(BattleDamageLog::outputLog($log['content']));
   	}

}