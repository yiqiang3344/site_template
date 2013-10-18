<style>
    #questInfo_content table tr td{text-align:left}
</style>
<?php
list($startTime, $endTime) = array($questDropAddition['startTime'], $questDropAddition['endTime']);
if($action == 'copy'){
    $startTime += DAY_MINITUES * 7;
    $endTime += DAY_MINITUES * 7;
}
$rewardType = array(
    'ap'=>array('text'=>'行动力', 'value'=>'ap', 'rewardValue'=>0.5),
    'goldReward'=>array('text'=>'金钱掉落', 'value'=>'goldReward', 'rewardValue'=>2),
    'expReward'=>array('text'=>'经验值', 'value'=>'expReward', 'rewardValue'=>2),
    'reputationReward'=>array('text'=>'名声值', 'value'=>'reputationReward', 'rewardValue'=>2),
    'characterDropRate'=>array('text'=>'角色掉落率', 'value'=>'characterDropRate', 'rewardValue'=>2),
    'itemDropRate'=>array('text'=>'物品掉落率', 'value'=>'itemDropRate', 'rewardValue'=>2),
    'contribution'=>array('text'=>'贡献度', 'value'=>'contribution', 'rewardValue'=>2),
    'pointReward'=>array('text'=>'积分', 'value'=>'pointReward', 'rewardValue'=>2),
);
$hours = array();
for($i=0;$i<24;$i++){
    $hours[$i] = array('text'=>$i, 'value'=>$i);
}
$rewardText = 'ap';
list($startHour, $startMin, $startSec) = array(date('G',$questDropAddition['startTime']), date('i',$questDropAddition['startTime']), date('s',$questDropAddition['startTime']));
list($endHour, $endMin, $endSec) = array(date('G',$questDropAddition['endTime']), date('i',$questDropAddition['endTime']), date('s',$questDropAddition['endTime']));
?>
<fieldset id="questInfo_content">
	<legend><a href="#_self" onclick="jQuery(this).parent().parent().empty().hide();">关闭</a></legend>
	<h2><?php echo 'questIds:'.$questDropAddition['questIds'];?></h2>
	<div>
		<div style="float:left;">QUEST EVENT:</div>
		<div>
		<ul>
            <?php foreach($rewardType as $key=>$type){
                if($questDropAddition[$key]){
                    $rewardText = $key;
                    echo CHtml::tag('li', array(), $type['text'].' * '.$questDropAddition[$key]);
                }
            }?>
		</ul>
		</div>
	</div>
	<table style="border:1px solid green;width:100%">
		<tr>
			<td><?php echo CHtml::dropDownList('type', $rewardText, CHtml::listData($rewardType, 'value', 'text'));?></td>
            <td>*<?php echo CHtml::textField('value', $questDropAddition[$rewardText], array('size'=>5));?></td>
		</tr>	
		<tr>
			<td>startTime：</td>	
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
				        'attribute' => 'startTime',   
                        'value'=>date('Y-m-d',$startTime),
				        'name'=>'startTime1',   
				        'options' => array(   
				        'showAnim' => 'fold',   
				        'dateFormat' => 'yy-mm-dd',   
				        ),
				        'htmlOptions'=>array( 
				        	'readonly'=>'true',
				        	'value'=>date('Y-m-d',$startTime),
				        ),
				));    
				?>
                <?php echo CHtml::dropDownList('startTime2', $startHour, CHtml::listData($hours, 'value', 'text'));?>
			</td>
		</tr>
		<tr>
			<td>endTime ：</td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
				        'attribute' => 'endTime',   
                        'value'=>date('Y-m-d',$endTime),
				        'name'=>'endTime1',   
				        'options' => array(   
				        'showAnim' => 'fold',   
				        'dateFormat' => 'yy-mm-dd',   
				        ),
				        'htmlOptions'=>array(  
				        	'readonly'=>'true',
				        	'value'=>date('Y-m-d',$endTime),
				        ),
				));
				?>
                <?php echo CHtml::dropDownList('endTime2', $endHour, CHtml::listData($hours, 'value', 'text'));?>
			</td>
		</tr>
	</table>
    <?php if($action == 'update'){?>
        <input type="button" value="修改" id="updateButton"/>
        <input type="button" value="删除" id="deleteButton"/>
    <?php }elseif($action == 'copy'){?>
        <input type="button" value="复制" id="copyButton"/>
    <?php }?>
</fieldset>
<script>
var rewardType = <?php echo CJSON::encode($rewardType);?>;
jQuery("#type").change(function(){
    var type = $(this).val();
    var value = rewardType[type]['rewardValue'];
    jQuery("#value").val(value);
});
jQuery("#startTime1").change(function(){
    checkTime();
});
jQuery("#startTime2").change(function(){
    checkTime();
});
jQuery("#endTime1").change(function(){
    checkTime();
});
jQuery("#endTime2").change(function(){
    checkTime();
});
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
jQuery("#updateButton").click(function(){updateQuest();});
jQuery("#copyButton").click(function(){copyQuest();});
jQuery("#deleteButton").click(function(){deleteQuest();});
function updateQuest(){
    if(!jQuery('#value').val().match(/^\d.*$/) || jQuery('#value').val()<=0){
        alert(jQuery('#type').val()+'值必须大于0');
        return false;
    }
    var questIds = '';
    questIds = '<?php echo $questDropAddition['questIds'];?>';
    var data ='';
    data += '&questIds='+questIds;
    data +='&type='+jQuery('#type').val();	
    data +='&value='+jQuery('#value').val();	

    data += '&startTime1='+jQuery('#startTime1').val();
    data += '&startTime2='+ jQuery('#startTime2').val();

    data += '&endTime1='+jQuery('#endTime1').val();
    data += '&endTime2='+ jQuery('#endTime2').val();

    SevenLoader.get("<?php echo $this->createUrl('questSet/editQuest',array('id'=>$questDropAddition['id']));?>"+data,updateCallback);
}
function copyQuest(){
    if(!jQuery('#value').val().match(/^\d.*$/) || jQuery('#value').val()<=0){
        alert(jQuery('#type').val()+'值必须大于0');
        return false;
    }
    var questIds = '';
    questIds = '<?php echo $questDropAddition['questIds'];?>';
    var data ='';
    data += '&questIds='+questIds;
    data +='&type='+jQuery('#type').val();	
    data +='&value='+jQuery('#value').val();	

    data += '&startTime1='+jQuery('#startTime1').val();
    data += '&startTime2='+ jQuery('#startTime2').val();

    data += '&endTime1='+jQuery('#endTime1').val();
    data += '&endTime2='+ jQuery('#endTime2').val();

    SevenLoader.get("<?php echo $this->createUrl('questSet/copyQuest',array('id'=>$questDropAddition['id']));?>"+data,updateCallback);
}

var updateCallback = function(res){
    alert(res.message);
    if(res.flag){
        reLoad();
    }
}
var deleteQuest = function(){
    var id = <?php echo $questDropAddition['id'];?>;
    var message = "是否确定删除批次"+id+"?";
    if(confirm(message)){
        SevenLoader.get("<?php echo $this->createUrl('questSet/deleteQuest',array('id'=>$questDropAddition['id']));?>",deleteCallback);		
    }
}
var deleteCallback = function(){
    alert('删除完毕！');
    location.href="<?php echo $this->createUrl('questSet/viewEvent');?>";
}
</script>
