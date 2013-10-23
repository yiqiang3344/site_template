<?php
require_once(dirname(__FILE__).'/constant.cfg.php');
$import = require_once(dirname(__FILE__).'/import.cfg.php');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'site1',
    'language' => 'dev',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>$import,

    'modules'=>array(
        'admin',
    ),

    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            /*
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
            */
        ),
        'cache'=>array(
            'class' => 'CDummyCache',
        ),
        'sessionCache'=>array(
            'class'=>'CMemCache',
            'keyPrefix' => 'SevenSession',
            'servers'=>array(
            ),
        ),

        // 'session'=>array(
        //     'class'=>'CCacheHttpSession',
        //     'cacheID'=>'sessionCache',
        //     'sessionName' => 'SID',
        //     'cookieMode' => 'only',
        //     'timeout' => 86400,
        // ),

        //使用数据库保存session
        'session' => array (
            'class' => 'CDbHttpSession',  
            'autoStart' => true,  
            'sessionTableName'=>'YiiSession',  
            'autoCreateSessionTable'=> false, 
            'connectionID' => 'db',
        ),

        // uncomment the following to use a MySQL database
        'db'=>array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=site1',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'yjq',
            'charset' => 'utf8',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, trace',
                ),
                // uncomment the following to show log messages on web pages
                
                // array(
                //     'class'=>'CWebLogRoute',
                // ),
                
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
    ),
);
