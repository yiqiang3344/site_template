<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php Global $v ?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/basic-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/page-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/page_a-min.css?v=<?php echo $v; ?>" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/jquery-1.5.2.min.js"></script>
<style>
body {
    font-size:12px; margin:0; padding:0; text-align:center; background-color: #FFFFFF
}
.block {
	width:950px; height:auto; margin:auto; clear:both;
}
fieldset {
	color:#666; margin-top:10px; display:block; text-align:left;
}
legend {
	font-weight:bold; color:#360; text-align:left;
}




table {
    border-width:1px; border-color:black; border-collapse:collapse; margin:auto;
}
th,td {
    border-width:1px; border-style:inset; border-color:black; valign="middle";
}


</style>
</head>
<body style="background-color:LightGoldenrodYellow">
<br>

<div class="block">
<?php echo $content; ?>
</div>


</body>
</html>