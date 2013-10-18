<style>
    #questContainer table{width:100%;}
    #questContainer th,#questContainer td{text-align: center;border :1px solid #ccc;}
</style>
<?php
$questList = $allQuests;
array_unshift($questList, array('questId'=>0, 'text'=>'请选择'));
$hours = array();
for($i=0;$i<24;$i++){
    $hours[$i] = array('text'=>$i, 'value'=>$i);
}
$arguments = array();
?>
<form id="form" method="POST">
<fieldset id='questContainer'>
	<legend>选择Quest</legend>
    <table>
        <tr>
	        <th width="5%">questId</th>
	        <th width="20%">questTitle</th>
	        <th width="12%">依赖主</th>
	        <th width="25%">说明文字</th>
	        <th width="6%">操作</th>
        </tr>
    </table>
    <br /><br />
    添加quest:
    <?php echo CHtml::dropDownList('allQuests', 0, CHtml::listData($questList, 'questId', 'text'));?>
    <?php echo CHtml::htmlButton('添加', array('class'=>'addButton'));?>
</fieldset>
<fieldset class="">
	<legend>添加Quest-Event<a href="<?php echo $this->createUrl('questEvent/index');?>">返回</a></legend>
	<label id="warning" style="color:red"></label>
<form id="form" method="POST">
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
			        'attribute' => 'endTime',   
                    'value' => date('Y-m-d'),
			        'name'=>'endTime1',   
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
            <?php echo CHtml::dropDownList('endTime2', 23, CHtml::listData($hours, 'value', 'text'));?>
		</td>
	</tr>
	<tr><td><input type="reset" value="reset" /></td><td><input type="submit" value="提交" /></td></tr>
	</table>
</form>	
</fieldset>
<script>
var allQuests = <?php echo CJSON::encode($allQuests);?>;
jQuery(document).ready(function(){
    jQuery('.addButton').bind('click', function(){addQuest();});
});
var addQuest = function(){
	var questId = jQuery("#allQuests").val();
    if(questId == 0){
        alert('请选择quest');
        return false;
    }
    if (jQuery("#quest"+questId).length > 0) {
        alert('quest' + questId + ' 已经存在~~');
        return false;
    }
    var quest = allQuests[questId];
    var questStr = "<tr id='quest"+quest.questId+"'>";
    questStr += "<input type='hidden' name='selectedId[]' value='"+quest.questId+"'/>";
    questStr += "<td>" + quest.questId + "</td>";
    questStr += "<td>" + quest.questName + "</td>";
    questStr += "<td>" + quest.questClient + "</td>";
    questStr += "<td>" + quest.questStory + "</td>";
    questStr += "<td><button onclick='deletequest("+quest.questId+")'>删除</button></td>";
    questStr += "</tr>";
    jQuery("#questContainer table").append(questStr);
}
var deletequest = function(id){
    jQuery("#quest"+id).remove();
}
</script>
