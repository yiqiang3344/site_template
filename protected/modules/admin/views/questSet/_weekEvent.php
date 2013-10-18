<table>
	<tr>
		<th width="10%">日期</th>
		<th width="30%">rank/quest</th>
		<th width="20%">重复类型</th>
		<th width="20%">开始时间</th>
		<th width="20%">结束时间</th>
	</tr>
</table>
<table>	
<?php foreach ($events as $week=>$event){?>
	<tr style="border:1px solid #ccc">
		<td>
		<?php 
		switch($week){
			case 1:echo '星期一:';break;
			case 2:echo '星期二:';break;
			case 3:echo '星期三:';break;
			case 4:echo '星期四:';break;
			case 5:echo '星期五:';break;
			case 6:echo '星期六:';break;
			case 7:echo '星期七:';break;		
		}
		?>
		</td>
		<td>
		<table>
		
		<tr>
		<?php foreach ($event as $e){?>
		<td width="35%"><?php echo $e['rank'].'/'.Yii::t('QuestName',$e['questTitle']);?></td>
		<td width="15%">
		<?php 
		switch($week){
			case 1:echo "仅此一次";break;
			case 2:echo "每日重复";break;
			case 3:echo "每周重复";break;
			case 4:echo "每月重复";break;
			default:echo '无';break;			
		}
		?></td>
		<td width="25%"><?php echo date('Y-m-d l H:i:s',$e['startTime']);?></td>
		<td width="25%"><?php echo date('Y-m-d l H:i:s',$e['endTime']);?></td>
		<?php }?>
		</tr>
		</table>
		
		
		</td>	
	</tr>
<?php }?>	
	
</table>









