<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试用户管理</title>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/jquery-1.5.2.min.js"></script>
<script language="javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/seven.js"></script>
<style type="text/css">
body {
	font-size:12px; margin:0; padding:0; text-align:center; text-align:center;
}
ul,li,p {
	margin:0; padding:0;
}
.block {
	width:950px; height:auto; margin:auto; clear:both;
}
a {
	padding:5px; color:#666; text-decoration:underline ;
}
table {
    border-width:1px; border-color:black; border-collapse:collapse; margin:auto;
}
th,td {
    border-width:1px; border-style:inset; border-color:black;
}
.btn {
    BORDER-RIGHT: #7b9ebd 1px solid; PADDING-RIGHT: 2px; BORDER-TOP: #7b9ebd 1px solid; PADDING-LEFT: 2px; FONT-SIZE: 12px; FILTER: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffffff, EndColorStr=#cecfde); BORDER-LEFT: #7b9ebd 1px solid; CURSOR: hand; COLOR: black; PADDING-TOP: 2px; BORDER-BOTTOM: #7b9ebd 1px solid
}

</style>

</head>
<body <?php $background = ModuleUtil::loadconfig('admin', 'background'); if($background['SHOW_BACKGROUND_COLOR'] == 1){ ?> style="background-color:<?php echo $background['BACKGROUND_COLOR'] ?>" <?php } ?>>
<div class="block">
<?php echo $content; ?>
</div>
<div class="block">
</div>

</body>
</html>