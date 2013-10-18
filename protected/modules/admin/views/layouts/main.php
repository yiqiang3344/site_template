<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
    <?php Global $v ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css" />
        <?php Global $v ?>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/basic-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/page-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/page_a-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
        
        
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/jquery-1.5.2.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/seven.js?v=<?php echo $v; ?>"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/flipsnap.js?v=<?php echo $v; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/common-min.js?v=<?php echo $v; ?>" type="text/javascript" charset="utf-8"></script>
        
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.sprintf.js?v=<?php echo $v; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.url.js?v=<?php echo $v; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/MathUtil.js?v=<?php echo $v; ?>" type="text/javascript" charset="utf-8"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page" <?php $background = ModuleUtil::loadconfig('admin', 'background'); if($background['SHOW_BACKGROUND_COLOR'] == 1){ ?> style="background-color:<?php echo $background['BACKGROUND_COLOR'] ?>" <?php } ?>>
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('default/index')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('default/logout'), 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>