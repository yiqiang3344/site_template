<?php if(!empty($result)){?>
		<table  width = "600px">
		<?php 
			foreach($result as $file=>$content){?>
			<tr>
				<th><?php echo $file;?></th>
				</tr>
				<?php foreach($content as $key=>$value){?>
					   <tr> <td><?php echo $key;?></td><td><?php echo $value; ?></td></tr>
				
				<?php }?>

		<?php }?>
		</table>
		<?php }
		else {?>
		 <h4><?php echo Yii::t('AdminModule.LanguageCompare', 'No Result');?></h4>
		<?php }?>
<br><br>
<?php echo CHtml::link(Yii::t('AdminModule.LanguageCompare', 'RETURN'), array('index')); ?>