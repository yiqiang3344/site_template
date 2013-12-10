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
            var CONTROLLER=<?php echo json_encode($this->getId());?>;
            var BASEURL=<?php echo json_encode(Yii::app()->getBaseUrl());?>;
            var BASEURI=<?php echo json_encode(Yii::app()->getBaseUrl() . "/index.php");?>;
            var LANG=<?php echo json_encode(Yii::app()->language);?>;
            var STIME=<?php echo Y::getTime();?>;
            var CTIME=new Date().getTime();
            var TEST_SERVER_FLAG=<?php echo YII_DEBUG;?>;
            var VERSION=<?php echo json_encode(A::VERSION);?>;
            var UD = <?php echo json_encode($this->getUD());?>;
        </script>
        <?php if(Yii::app()->language=='dev'):?>
        <script type="text/javascript" src="<?php echo $this->url("js/tools.js");?>"></script>
        <script type="text/javascript" src="<?php echo $this->url("js/main.js");?>"></script>
        <script type="text/javascript" src="<?php echo $this->url('js/url.js');?>"></script>
        <?php else:?>
        <script type="text/javascript" src="<?php echo $this->url("js/all.js");?>"></script>
        <?php endif;?>
        <?php if($this->template_flag==S::DEV_USE_TEMPLATE):?>
            <script type="text/javascript">
                //设置子模板编译方法，dev中才有定义
                <?php if(Yii::app()->language=='dev'):?>
                    <?php foreach(array_merge($this->partialsSubTemplate,$this->publicSubTemplate) as $k=>$v):?>
                    var <?php echo $k;?> = Hogan.compile(<?php echo json_encode($v);?>);
                    <?php endforeach;?>
                <?php endif;?>
            </script>
        <?php endif;?>
        <script type="text/javascript" src="<?php echo $this->url('js/helper.js');?>"></script>
        <?php if($this->template_flag==S::DEV_USE_TEMPLATE):?>
            <!-- 倒入含有局部子模板编译方法的js文件 -->
            <?php if(Yii::app()->language!='dev' && $this->partialsSubTemplate):?>
            <script type="text/javascript" src="<?php echo $this->url('js/'.$this->getId().'_sub_template.js');?>"></script>
            <?php endif;?>
        <?php endif;?>
    </head>
    <body>
        <div id="maindiv">
            <?php echo $this->Mustache->render($this->publicSubTemplate['headerTemplate'],$this->getHeaderParams()); ?>
            <?php echo $content;?>
            <?php echo $this->Mustache->render($this->publicSubTemplate['footerTemplate'],$this->getFooterParams()); ?>
        </div>
        <script type="text/javascript">
        $('.js_logout').click(function() {
            oneAjax('Site', 'AjaxLogout', {}, function(obj) {
                if (obj.code === 1) {
                    State.back(0);
                }
            }, this);
            return false;
        });
        </script>
    </body>
</html>

