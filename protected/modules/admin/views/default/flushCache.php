<form name="form1" action="<?php echo $this->createUrl('default/flushCache') ?>" method="post">
	<?php
		$how = 4; //验证码位数
		$alpha = "abcdefghijkmnopqrstuvwxyz"; //验证码内容1:字母
		$number = "023456789"; //验证码内容2:数字
		$randcode = ""; //验证码字符串初始化
		srand((double)microtime()*1000000); //初始化随机数种子
		/*
		* 逐位产生随机字符
		*/
		for($i=0; $i<$how; $i++)
		{   
			$alpha_or_number = mt_rand(0, 1); //字母还是数字
			$str = $alpha_or_number ? $alpha : $number;
			$which = mt_rand(0, strlen($str)-1); //取哪个字符
			$code = substr($str, $which, 1); //取字符
			$randcode .= $code; //逐位加入验证码字符串
		}
		echo "验证码: <strong>".$randcode."</strong>";		
		//把验证码字符串写入session
		$_SESSION['randcode'] = $randcode;
	?>
	<input type="text" name="verification" value="" />
    <input type="button" name="flush" value="<?php echo Yii::t('View', 'flush') ?>" onclick="flushCache()"/>
</form>
<?php if ($blankFlag) {
    echo Yii::t('View', 'Can not be blank');
    }
?>
<?php if ($flushFlag) {
    echo Yii::t('View', 'flushCacheSuccess');
    }
?>
<?php if ($errorFlag) {
    echo Yii::t('View', 'verificationerror');
    }
?>
<div id="message"></div>
<script type="text/javascript">
    function flushCache() {
		var bln = window.confirm("<?php echo Yii::t('View', 'flushCacheConfirm') ?>");
		if (bln == true) {
			document.form1.submit();
			
		}else {
		
		}
	}
</script>