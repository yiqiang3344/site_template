<style>
    #eventContainer table{width:100%;}
    #eventContainer th,#eventContainer td{text-align: center;border :1px solid #ccc;}
</style>
<?php
$statusType = array(
    '0'=>array('text'=>'请选择', 'value'=>0, 'color'=>''),
    '1'=>array('text'=>'未开始', 'value'=>1, 'color'=>'blue'),
    '2'=>array('text'=>'进行中', 'value'=>2, 'color'=>'red'),
    '3'=>array('text'=>'已结束', 'value'=>3, 'color'=>'grey'),
);
$hours = array();
for($i=0;$i<24;$i++){
    $hours[$i] = array('text'=>$i, 'value'=>$i);
}
?>
<form id="form" method="POST">
<fieldset id='eventContainer'>
	<legend>选择Event</legend>
    <table>
        <tr>
	        <th width="5%">eventId</th>
	        <th width="5%">questId</th>
	        <th width="20%">questTitle</th>
	        <th width="12%">依赖主</th>
	        <th width="25%">说明文字</th>
	        <th width="10%">开始时间</th>
	        <th width="10%">结束时间</th>
	        <th width="7%">状态</th>
	        <th width="6%">操作</th>
        </tr>
        <?php
            $arguments = compact("statusType");
            array_walk($events, function($event, $key, $arguments){
                extract($arguments);
                $quest = $event['quest'];
                $status = $statusType[$event['status']];
                echo CHtml::openTag('tr', array('id'=>'event' . $event['id']));
                echo CHtml::tag('input', array('type'=>'hidden', 'name'=>'selectedId[]', 'value'=>$event['id']));
                echo CHtml::tag('td', array(), $event['id']);
                echo CHtml::tag('td', array(), $quest['questId']);
                echo CHtml::tag('td', array(), $quest['questName']);
                echo CHtml::tag('td', array(), $quest['questClient']);
                echo CHtml::tag('td', array(), $quest['questStory']);
                echo CHtml::tag('td', array(), $event['startTime']);
                echo CHtml::tag('td', array(), $event['endTime']);
                echo CHtml::tag('td', array(), $status['text']);
                echo CHtml::openTag('td');
                echo CHtml::htmlButton('删除', array('onclick'=>"deleteEvent(" . $event['id'] . ")"));
                echo CHtml::closeTag('td');
                echo CHtml::closeTag('tr');
            }, $arguments);
        ?>
    </table>
    <br /><br />
    添加event:
    <?php echo CHtml::dropDownList('allEvents', 0, CHtml::listData($allEvents, 'id', 'text'));?>
    <?php echo CHtml::htmlButton('添加', array('class'=>'addButton'));?>
</fieldset>
<fieldset class="">
	<legend>编辑Quest-Event<a href="<?php echo $this->createUrl('questEvent/index');?>">返回</a></legend>
	<table>
	<tr><td>开始时间:</td>
		<td>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
			        'attribute' => 'startTime',   
                    'value' => date('Y-m-d'),
			        'name'=>'startTime1',   
			        'options' => array(   
			            'showAnim' => 'fold',   
			            'dateFormat' => 'yy-mm-dd',   
			        ),
			        'htmlOptions'=>array(
			        	'readonly'=>'true',
                        'value' => date('Y-m-d'),
                        'style' => 'text-align:center;',
			        ),
			));    
			?>
            <?php echo CHtml::dropDownList('startTime2', 0, CHtml::listData($hours, 'value', 'text'));?>
		</td>
	</tr>
	<tr><td>结束时间:</td>
		<td>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
			        'attribute' => 'startTime',   
                    'value' => date('Y-m-d'),
			        'name'=>'endTime1',   
			        'options' => array(   
			        'showAnim' => 'fold',   
			        'dateFormat' => 'yy-mm-dd',   
			        ),
			        'htmlOptions'=>array(
			        	'readonly'=>'true',
			        	'value'=>date('Y-m-d'),
                        'style' => 'text-align:center;',
			        ),
			));    
			?>
            <?php echo CHtml::dropDownList('endTime2', 23, CHtml::listData($hours, 'value', 'text'));?>
		</td>
	</tr>
	<tr><td>&nbsp;</td><td><input type="submit" value="提交"></td></tr>
	</table>
</fieldset>
</form>	
<script>
var allEvents = <?php echo CJSON::encode($allEvents);?>;
var statusType = <?php echo CJSON::encode($statusType);?>;
jQuery(document).ready(function(){
    jQuery('.addButton').bind('click', function(){addEvent();});
});
var addEvent = function(){
	var eventId = jQuery("#allEvents").val();
    if(eventId == 0){
        alert('请选择event');
    }
    if (jQuery("#event"+eventId).length > 0) {
        alert('event' + eventId + ' 已经存在~~');
        return false;
    }
    var event = allEvents[eventId];
    var eventStr = "<tr id='event"+event.id+"'>";
    eventStr += "<input type='hidden' name='selectedId[]' value='"+event.id+"'/>";
    eventStr += "<td>" + event.id + "</td>";
    eventStr += "<td>" + event.quest.questId + "</td>";
    eventStr += "<td>" + event.quest.questName + "</td>";
    eventStr += "<td>" + event.quest.questClient + "</td>";
    eventStr += "<td>" + event.quest.questStory + "</td>";
    eventStr += "<td>" + event.startTime + "</td>";
    eventStr += "<td>" + event.endTime + "</td>";
    eventStr += "<td>" + statusType[event.status].text + "</td>";
    eventStr += "<td><button onclick='deleteEvent("+event.id+")'>删除</button></td>";
    eventStr += "</tr>";
    jQuery("#eventContainer table").append(eventStr);
}
var deleteEvent = function(id){
    jQuery("#event"+id).remove();
}
</script>
