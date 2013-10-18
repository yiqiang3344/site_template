<style>
    ul li{list-style-type:none;}
    .questSetContainer ul li{line-height:30px;font-size:16px;}
    .clear{clear:both}
	#addDropAdditionTable tr{line-height:23px;}
	#addDropAdditionTable tr td{text-align:left}
</style>
<?php
$rewardType = array(
    'ap'=>array('linkText'=>'行动力1/2', 'rewardValue'=>'0.5', 'text'=>'行动力', 'value'=>'ap'),
    'goldReward'=>array('linkText'=>'金钱掉落*2', 'rewardValue'=>'2', 'text'=>'金钱掉落', 'value'=>'goldReward'),
    'expReward'=>array('linkText'=>'经验值*2', 'rewardValue'=>'2', 'text'=>'经验值', 'value'=>'expReward'),
    'reputationReward'=>array('linkText'=>'名声值*2', 'rewardValue'=>'2', 'text'=>'名声值', 'value'=>'reputationReward'),
    'characterDropRate'=>array('linkText'=>'角色掉落率*2', 'rewardValue'=>'2', 'text'=>'角色掉落率', 'value'=>'characterDropRate'),
    'itemDropRate'=>array('linkText'=>'物品掉落率*2', 'rewardValue'=>'2', 'text'=>'物品掉落率', 'value'=>'itemDropRate'),
    'contribution'=>array('linkText'=>'贡献度*2', 'rewardValue'=>'2', 'text'=>'贡献度', 'value'=>'contribution'),
    'pointReward'=>array('linkText'=>'积分*2', 'rewardValue'=>'2', 'text'=>'积分', 'value'=>'pointReward'),
);
$repeatType = array(
    0 => array('text'=>'选择类型', 'value'=>0),
    1 => array('text'=>'仅此一次', 'value'=>1),
    2 => array('text'=>'每日重复', 'value'=>2),
    3 => array('text'=>'每周重复', 'value'=>3),
    4 => array('text'=>'每月重复', 'value'=>4)
);
$rankSelect[0] = array('value'=>0, 'text'=>'选择rank');
foreach($rank as $rankId){
    $rankSelect[$rankId] = array('value'=>$rankId, 'text'=>'rank-'.$rankId);
}
$hours = array();
for($i=0;$i<24;$i++){
    $hours[$i] = array('text'=>$i, 'value'=>$i);
}
$rewardText = 'ap';
?>
<fieldset class="">
	<legend>当前日期：</legend>
	<?php echo date('Y-m-d l H:i:s',time());?>
</fieldset>
<fieldset class="questSetContainer" style="float:left;">
	<ul>
        <?php
        echo CHtml::tag('li', array(), CHtml::link('calendar', $this->createUrl('questSet/index')));
        foreach($rewardType as $key=>$reward){
            echo CHtml::tag('li', array(), CHtml::link($reward['linkText'], $this->createUrl('questSet/addQuest', array($key => $reward['rewardValue']))));
        }
        ?>
	</ul>
</fieldset>
<fieldset style="">
<form method="POST" id="addQuest">
<ul id="questList" style="margin:0 0 10px 10px;padding:5px;">
    <li>已选择的quest:</li>
</ul>
<div style="margin-left:10px;padding:5px;">
	<div>
	<div style="display:inline">
        <?php echo CHtml::dropDownList('rankId', 0, CHtml::listData($rankSelect, 'value', 'text'));?>
	</div>
	
	<div style="display:inline" id="questArea">
	</div>
    <br>
	<div style="display:inline">
        <?php echo CHtml::dropDownList('eventId', 0, CHtml::listData($eventList, 'value', 'text'));?>
	</div>
    <input type="button" id="addEventButton" value="添加event"/>
	</div>
	<table style="border:1px solid green;width:100%" id='addDropAdditionTable'>
		<tr>
            <td><?php echo CHtml::dropDownList('type', $type, CHtml::listData($rewardType, 'value', 'text'));?></td>
			<td>*<?php echo CHtml::textField('value', $value, array('size'=>5));?></td>
		</tr>
		<tr>
			<td>start：</td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
				        'attribute' => 'startTime',   
                        'value'=>date('Y-m-d', time()),
				        'name'=>'startTime1',   
				        'options' => array(   
				        'showAnim' => 'fold',   
				        'dateFormat' => 'yy-mm-dd',   
				        ),

				        'htmlOptions'=>array(  
				        	'readonly'=>'true',
				        	'value'=>date('Y-m-d',time()),
				        ),
				));    
				?>
                <?php echo CHtml::dropDownList('startTime2', 0, CHtml::listData($hours, 'value', 'text'));?>
			</td>
		</tr>
		<tr>
			<td>end ：</td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
				        'attribute' => 'endTime',   
                        'value'=>date('Y-m-d', time()),
				        'name'=>'endTime1',   
				        'options' => array(   
				        'showAnim' => 'fold',   
				        'dateFormat' => 'yy-mm-dd',   
				        ),
				        'htmlOptions'=>array(  
				        	'readonly'=>'true',
				        	'value'=>date('Y-m-d',time()),
				        ),
				));    
				?>
                <?php echo CHtml::dropDownList('endTime2', 23, CHtml::listData($hours, 'value', 'text'));?>
			</td>
		</tr>
		<!-- <tr>
			<td>重复方式：</td>
            <td><?php //echo CHtml::dropDownList('repeatType', 0, CHtml::listData($repeatType, 'value', 'text'));?></td>
		</tr> -->
	</table>
	<div style="text-align:center">
	<input type="submit" value="  提     交  " id="addButton" width="10px"/>
	</div>
</div>
</form>
<script>
var rewardType = <?php echo CJSON::encode($rewardType);?>;
jQuery('#rankId').change(function(){
	var rankId = jQuery(this).val();
	SevenLoader.get("<?php echo $this->createUrl('questSet/getQuestsByRank');?>&rankId="+rankId,selectRankCallback);
});
jQuery("#type").change(function(){
    var type = $(this).val();
    var value = rewardType[type]['rewardValue'];
    jQuery("#value").val(value);
});
jQuery('#addEventButton').click(function(){
	var eventId = jQuery("#eventId").val();
	var innerText = jQuery("#eventId").find("option:selected").text();
	if(eventId >0){
		if ($("#event_"+eventId).length > 0) {
			alert('quest 已经存在~~');
		}else{
			jQuery('#questList').append('<li id="event_'+eventId+'">'+innerText+'<input type="hidden" name="selectedId[]" value="'+eventId+'"/><input type="button" class="deleteQuestButton" onclick="jQuery(this).parent().remove();" value="删除"/></li>');
		}
	}else{
		alert('请选择event~~');
	}
});
jQuery('#addButton').click(function(){
	if(jQuery('#questList li').length <=1){
		alert('请选择至少一个quest');
		return false;
	}
	if(!jQuery('#value').val().match(/^\d.*$/) || jQuery('#value').val()<=0){
		alert(jQuery('#type').val()+'值必须大于0');
		return false;
	}	
	if(jQuery('#repeatType').val() == 0){
		alert('请选择重复类型');
		return false;
	}
    var questIds = new Array();
	var i = 0;   
	jQuery("input[name='selectedId[]']").each(function(){
		questIds[i] = $(this).val();    
        i++;   
	});

    var type = jQuery("#type").val();
    var value = jQuery("#value").val();

	var startTime1 = jQuery('#startTime1').val();
	var startTime2 = jQuery('#startTime2').val();
	var endTime1 = jQuery('#endTime1').val();
	var endTime2 = jQuery('#endTime2').val();
	
	//var repeatType = jQuery('#repeatType').val();
	
	var queryString = '&questIds='+questIds+'&additionType='+type+'&additionValue='+value+'&startTime1='+startTime1+'&startTime2='+startTime2+'&endTime1='+endTime1+'&endTime2='+endTime2;
    var url = '<?php echo $this->createUrl('questSet/checkAdd');?>' + queryString;
	SevenLoader.get(url,checkAddCallback);
    return false;
});
var checkAddCallback = function(res){
    if(res.message){
        alert(res.message);
    }
    if(res.flag){
        jQuery("#addQuest").submit();
    }
}
var selectRankCallback = function(res){
	jQuery('#questArea').html(res);
}
jQuery("#startTime1").change(function(){
    checkTime();
})
jQuery("#startTime2").change(function(){
    checkTime();
})
jQuery("#endTime1").change(function(){
    checkTime();
})
jQuery("#endTime2").change(function(){
    checkTime();
})
var checkTime = function(){
	var startTime1 = jQuery('#startTime1').val();
	var startTime2 = jQuery('#startTime2').val();
	var endTime1 = jQuery('#endTime1').val();
	var endTime2 = jQuery('#endTime2').val();
	SevenLoader.get('<?php echo $this->createUrl('questSet/checkTime')?>&startTime1='+startTime1+'&startTime2='+startTime2+'&endTime1='+endTime1+'&endTime2='+endTime2,checkCallback);	
}
var checkCallback = function(res){
	if(res){
		alert(res);
	}
}
</script>
</fieldset>
<div class="clear"></div>
<fieldset>
<?php $this->widget('application.modules.admin.components.widget.WeekEventQuest',array('time'=>strtotime(date('y',time()).'-'.date('m',time()).'-'.date('d',time())))); ?>
</fieldset>
