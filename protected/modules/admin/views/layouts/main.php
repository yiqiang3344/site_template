<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <title><?php echo CHtml::encode($this->pageTitle);?></title>
        <link href="<?php echo $this->url("css/base.css");?>" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo $this->url("css/page.css");?>" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo $this->url("js/jquery.js");?>"></script>
        <script type="text/javascript">
            var CODE_BASE_URL=<?php echo json_encode(Yii::app()->getBaseUrl() . "/index.php/".$this->module->getName());?>;
            var STIME=<?php echo Y::getTime();?>;
            var CTIME=new Date().getTime();
            var TEST_SERVER_FLAG=<?php echo YII_DEBUG;?>;
            window.UEDITOR_HOME_URL=<?php echo json_encode($this->getAssetsUrl().'/ueditor/');?>;
        </script>
        <script type="text/javascript" src="<?php echo $this->url('js/helper.js');?>"></script>
    </head>
    <body>
        <?php echo $content;?>
    </body>
</html>

