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
            var STATIC_BASE_URL=<?php echo json_encode(Yii::app()->getBaseUrl());?>;
            var CODE_BASE_URL=<?php echo json_encode(Yii::app()->getBaseUrl() . "/index.php");?>;
            var LANG=<?php echo json_encode(Yii::app()->language);?>;
            var STIME=<?php echo Y::getTime();?>;
            var CTIME=new Date().getTime();
            var TEST_SERVER_FLAG=<?php echo YII_DEBUG;?>;
            var VERSION=<?php echo json_encode(A::VERSION);?>;
        </script>
        <script type="text/javascript" src="<?php echo $this->url("js/main.js");?>"></script>
        <script type="text/javascript" src="<?php echo $this->url('js/url.js');?>"></script>
        <script type="text/javascript" src="<?php echo $this->url('js/helper.js');?>"></script>
    </head>
    <body>
        <div class="user_info">
            <?php $this->widget('CCaptcha',array(
                'showRefreshButton'=>false,
                'clickableImage'=>true,
                'imageOptions'=>array(
                    'alt'=>'点击换图',
                    'title'=>'点击换图',
                    'style'=>'cursor:pointer',
                )
            )); ?>
        </div>
        <?php echo $content;?>
    </body>
</html>

