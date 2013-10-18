<?php $form = $this->beginWidget('CActiveForm', array('id'=>'EditPushNotificationForm',)); ?>
<?php echo $form->errorSummary($model); ?>
<table>
    <tr><td width=100px><?php echo $form->labelEx($model, 'playerName'); ?></td><td><?php echo $form->textField($model,'playerName'); ?></td></tr>
    <tr><td width=100px></td><td><?php echo CHtml::submitButton('search'); ?></td></tr>
</table>
<?php $this->endWidget(); ?>
<hr>
<div id='playerInfo' style="-webkit-user-select:text;">
<?php if (!empty($playerInfo)) {?>
	<table>
	<?php foreach ($playerInfo as $key=>$value) {?>
	    <tr><td width=100px><?php echo $key . '：';?></td><td><?php echo $value;?></td></tr>
	<?php }?>
		<tr><td width=100px></td><td><button onclick=login('<?php echo $this->createUrl('playerInfo/login', array('UID'=>$playerInfo['deviceId']))?>')>login</button></td></tr>
	</table>
<?php }?>
</div>
<style>
	table {font-size:16px;}
</style>
<script type='text/javascript'>
	function login(url) {
		window.open(url);
	}
</script>
