<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dev Tools</title>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/seven2.js"></script>
<style>
body {
	font-size:12px; margin:0; padding:0; text-align:center; text-align:center;
}
ul,li,p {
	margin:0; padding:0;
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
a {
	padding:5px; color:#666; text-decoration:underline ;
}
a:hover{
	color:#F00;
}
.checked {
	background-color:#E9EFCB;
}
.line {
	width:100%; height:10px; clear:both;
}
.fl {
	float:left;
}
.fr {
	float:right;
}
.w450 {
	width:445px;
}
.w15 {
	width:15px;
}
.w35 {
	width:35px;
}
.dialogcontent {
	 overflow-y:scroll; border:solid 5px #ddd;
}
.red {
     color:red;
}

</style>
</head>
<body <?php $background = ModuleUtil::loadconfig('admin', 'background'); if($background['SHOW_BACKGROUND_COLOR'] == 1){ ?> style="background-color:<?php echo $background['BACKGROUND_COLOR'] ?>" <?php } ?>>
<div class="block">
<?php echo $content; ?>
</div>
<div id="questInfo" style="position:absolute;top:100px;right:450px;width:500px;background-color:#ccc;display:none;"></div>
</body>
</html>
