<style>
    td {text-align:center;width:20px;height:20px;border:1px solid #ccc;}
    .cutline {float:left;font-size:15px;}
    .cutline div {border:1px solid #ccc;height:12px;width:12px;display:inline-block;}
</style>
<?php
$eventIds = QuestQuery::getAllEventIds();
array_walk($eventIds, function(&$eventId, $key){
    $value['value'] = $eventId;
    $value['text'] = $eventId;
    $eventId = $value;
});
array_unshift($eventIds, array('value'=>0, 'text'=>'请选择'));
$rewardType = array(
    '0'=>array('text'=>'请选择', 'value'=>0),
    'ap'=>array('text'=>'行动力', 'value'=>'ap'),
    'goldReward'=>array('text'=>'金钱掉落', 'value'=>'goldReward'),
    'expReward'=>array('text'=>'经验值', 'value'=>'expReward'),
    'reputationReward'=>array('text'=>'名声值', 'value'=>'reputationReward'),
    'characterDropRate'=>array('text'=>'角色掉落率', 'value'=>'characterDropRate'),
    'itemDropRate'=>array('text'=>'物品掉落率', 'value'=>'itemDropRate'),
    'contribution'=>array('text'=>'贡献度', 'value'=>'contribution'),
    'pointReward'=>array('text'=>'积分', 'value'=>'pointReward'),
);
$statusType = array(
    '0'=>array('text'=>'请选择', 'value'=>0, 'color'=>''),
    '1'=>array('text'=>'未开始', 'value'=>1, 'color'=>'blue'),
    '2'=>array('text'=>'进行中', 'value'=>2, 'color'=>'red'),
    '3'=>array('text'=>'已结束', 'value'=>3, 'color'=>'grey'),
);

function getTimeString($timestamp){
    $timeString = date('Y-m-d H:i:s',$timestamp);
    $timeString .= '<br>' . date('l', $timestamp);
    return $timeString;
}
?>
<fieldset class="">
	<legend>当前日期：</legend><?php echo date('Y-m-d l H:i:s',time());?>
</fieldset>
<fieldset>
    <legend>过滤器</legend>
    <form method="POST" id="filter">
        <table style="width:100%;margin:0;padding:0;">
            <tr>
                <?php
                    echo CHtml::tag('td', array(), '开始批次id');
                    echo CHtml::tag('td', array('style'=>'width:12%;'), CHtml::dropDownList('startEventId', $filter['startEventId'], CHtml::listData($eventIds, 'value', 'text')));
                    echo CHtml::tag('td', array(), '结束批次id');
                    echo CHtml::tag('td', array('style'=>'width:12%;'), CHtml::dropDownList('endEventId', $filter['endEventId'], CHtml::listData($eventIds, 'value', 'text')));
                    echo CHtml::tag('td', array(), '活动类型');
                    echo CHtml::tag('td', array('style'=>'width:12%;'), CHtml::dropDownList('rewardType', $filter['rewardType'], CHtml::listData($rewardType, 'value', 'text')));
                    echo CHtml::tag('td', array(), '状态');
                    echo CHtml::tag('td', array('style'=>'width:12%;'), CHtml::dropDownList('status', $filter['status'], CHtml::listData($statusType, 'value', 'text')));
                ?>
            </tr>
            <tr>
                <?php
                    echo CHtml::tag('td', array('colspan'=>8, 'style'=>'text-align:right;padding-right:30px;'), CHtml::submitButton('筛选'));
                ?>
            </tr>
        </table>
    </form>
</fieldset>
<fieldset class="">
<legend><?php echo CHtml::link('calendar', $this->createUrl('questSet/index'));?></legend>
<div style='float:right;margin-bottom:7px;'>
    <div class='cutline'><div style="background-color:<?php echo $statusType[1]['color'];?>;"></div>未开始&nbsp;&nbsp;</div>
    <div class='cutline'><div style="background-color:<?php echo $statusType[2]['color'];?>;"></div>进行中&nbsp;&nbsp;</div>
    <div class='cutline'><div style="background-color:<?php echo $statusType[3]['color'];?>;"></div>已结束&nbsp;&nbsp;</div>
</div>
<table style="width:100%;margin:0;padding:0;">
	<tr style="border:1px solid #ccc">
		<td style="width:4%">id</td>
		<td style="width:39%" colspan="2">quest</td>
		<td style="width:10%">活动内容</td>
		<td style="width:15%">开始时间</td>
		<td style="width:15%">结束时间</td>
		<td style="width:6%">状态</td>
		<td style="width:10%" colspan="2">操作</td>
	</tr>
</table>
<table style="width:100%;margin:0;padding:0;">
<?php if(is_array($allEvents)){?>
<?php foreach ($allEvents as $key=>$event){?>
    <tr style="border:1px solid #ccc;color:<?php echo $statusType[$event['status']]['color'];?>">
		<td style="width:4%"><?php echo $key;?></td>
        <td style="width:39%">
            <table style="width:100%;margin:0;padding:0;">
                <?php 
                    array_walk($event['quests'], function($quest, $key){
                        echo CHtml::openTag('tr');
                        echo CHtml::tag('td', array('style'=>'width:18%;'), $key);
                        $rank = $quest['rank'] ? ('rank-'.$quest['rank']) : 'Event';
                        echo CHtml::tag('td', array('style'=>'width:18%;'), $rank);
                        echo CHtml::tag('td', array('style'=>'width:64%;'), $quest['questTitleText']);
                        echo CHtml::closeTag('tr');
                    });
                ?>
           </table>
        </td>
        <td style="width:10%"><?php echo $event['dropAdditionType'];?></td>
		<td style="width:15%;text-align:center"><?php echo getTimeString($event['startTime']);?></td>
		<td style="width:15%;text-align:center"><?php echo getTimeString($event['endTime']);?></td>
        <td style="width:6%"><?php echo $statusType[$event['status']]['text'];?></td>
        <td style="width:4.9%"><a onclick="viewEvent(<?php echo $event['id'];?>);" style='color:<?php echo $statusType[$event['status']]['color'];?>;'>编辑</a></td>
		<td style="width:4.9%"><a onclick="deleteEvent(<?php echo $event['id'];?>);" style='color:<?php echo $statusType[$event['status']]['color'];?>;'>删除</a></td>
	</tr>
<?php }?>	
<?php }else{?>
	<tr style="border:1px solid #ccc"><td>no event</td></tr>
<?php }?>
</table>
</fieldset>
<script>
function viewEvent(id){
	SevenLoader.get('<?php echo $this->createUrl('questSet/getEventInfo');?>&id='+id,viewEventCallback);
}
var viewEventCallback = function(res){
	jQuery('#questInfo').html(res);
	jQuery('#questInfo').show();
}
function deleteEvent(id){
    var message = "是否确定删除批次"+id+"?";
    if(confirm(message)){
        SevenLoader.get('<?php echo $this->createUrl('questSet/deleteQuest');?>&id='+id,deleteCallback);
    }
}
var deleteCallback = function(){
	alert('已经删除');
	location.href="<?php echo $this->createUrl('questSet/allEvents');?>";
}
var reLoad = function(){
    location.reload();
}
</script>
