<style>
    .questSetContainer ul li{line-height:30px;font-size:14px;list-style-type:none;}
    .questSetContainer {padding:5px;}
    .eventArea {float:left;}
</style>
<fieldset class="">
	<legend>当前选择的日期：</legend>
<?php
$prevTime = strtotime('-1 day',strtotime($year.'-'.$month.'-'.$day));
$nextTime = strtotime('+1 day',strtotime($year.'-'.$month.'-'.$day));
$weeks = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');    
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
?>
<?php
echo CHtml::link($weeks[date('w', $prevTime)], $this->createUrl('questSet/viewEvent',array('year'=>date('Y',$prevTime),'month'=>date('m',$prevTime),'day'=>date('d',$prevTime))));
echo $year.'年'.$month.'月'.$day.'日'.$weeks[date('w',$dateStartTime)];
echo CHtml::link($weeks[date('w', $nextTime)], $this->createUrl('questSet/viewEvent',array('year'=>date('Y',$nextTime),'month'=>date('m',$nextTime),'day'=>date('d',$nextTime))));
?>
</fieldset>
<div>
<fieldset class="questSetContainer" style="float:left;width:130px;">
	<ul>
        <?php
        echo CHtml::tag('li', array(), CHtml::link('calendar', $this->createUrl('questSet/index')));
        echo CHtml::tag('li', array(), CHtml::link('全部活动', $this->createUrl('questSet/viewEvent', array('year'=>$year,'month'=>$month,'day'=>$day)), array('class'=> $type ? '' : 'red')));
        foreach($rewardType as $key=>$reward){
            echo CHtml::tag('li', array(), CHtml::link($reward['linkText'], $this->createUrl('questSet/viewEvent', array('year'=>$year,'month'=>$month,'day'=>$day,'type'=>$key)), array('class'=>$type==$key ? 'red' : '')));
        }
        echo CHtml::tag('li', array(), CHtml::link('++ 新增活动 ++', $this->createUrl('questSet/addQuest')));
        ?>
	</ul>
</fieldset>
<?php
if(is_array($quests)){
    echo CHtml::openTag('div', array('class'=>'eventArea'));
    array_walk($quests, function($event, $key){
        echo CHtml::openTag('fieldset', array('class'=>'questSetContainer', 'style'=>'margin-left:10px;'));
        echo CHtml::tag('legend', array('style'=>'font-size:20px;'), CHtml::link($key, '#_self', array('onclick'=>"viewEvent($key)")));
        echo CHtml::openTag('ul');
        array_walk($event['quests'], function($quest, $key){
            $content = "questId:" . $quest['questId'] . "、" . 'rank' . $quest['rank'] . '-' . $quest['questTitle'] . '&nbsp;&nbsp;' . $quest['questTitleText'];
            echo CHtml::tag('li', array('style'=>'text-decoration:underline;'), $content);
        });
        echo CHtml::closeTag('ul');
        echo CHtml::htmlButton('copy', array('data-id'=>$key, 'class'=>'copy'));
        echo CHtml::closeTag('fieldset');
    });
    echo CHtml::closeTag('div');
}
?>
<script>
jQuery('.copy').bind('click', function(){
    var id = $(this).attr('data-id');
    copyEvent(id);
});
function copyEvent(id){
	SevenLoader.get('<?php echo $this->createUrl('questSet/getEventInfo',array('year'=>$year,'month'=>$month,'day'=>$day));?>&do=copy&id='+id,viewEventCallback);
}
function viewEvent(id){
	SevenLoader.get('<?php echo $this->createUrl('questSet/getEventInfo',array('year'=>$year,'month'=>$month,'day'=>$day));?>&do=update&id='+id,viewEventCallback);
}
var viewEventCallback = function(res){
	jQuery('#questInfo').html(res);
	jQuery('#questInfo').show();
}
var reLoad = function(){
    location.reload();
}
</script>
<div style="clear:both;"></div>
<br/>
</div>
<fieldset>
<?php $this->widget('application.modules.admin.components.widget.WeekEventQuest',array('time'=>strtotime($year.'-'.$month.'-'.$day))); ?>
</fieldset>
