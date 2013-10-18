<style>
    table {width:100%;}
    th,td {text-align: center;border :1px solid #ccc;}
    a {margin:3px;}
    .red {color:red;}
    .green {color:green;}
    .blue {color:blue;}
    .cutline {float:left;font-size:15px;}
    .cutline div {border:1px solid #ccc;height:12px;width:12px;display:inline-block;}
    a{text-decoration:none;line-height:25px;width:25px;border:1px solid gray;}
    .on{background-color:gray;color:white;}
</style>
<?php
$statusType = array(
    '0'=>array('text'=>'请选择', 'value'=>0, 'color'=>''),
    '1'=>array('text'=>'未开始', 'value'=>1, 'color'=>'blue'),
    '2'=>array('text'=>'进行中', 'value'=>2, 'color'=>'red'),
    '3'=>array('text'=>'已结束', 'value'=>3, 'color'=>'grey'),
);
$multiHandleType = array(
    '0' => array('value'=>0, 'text'=>'请选择'),
    '1' => array('value'=>1, 'text'=>'编辑'),
    '2' => array('value'=>2, 'text'=>'删除'),
);
rsort($allQuestIds);
array_walk($allQuestIds, function(&$questId, $key){
    $value['questId'] = $questId;
    $value['text'] = $questId;
    $questId = $value;
});
array_unshift($allQuestIds, array('questId'=>0, 'text'=>'请选择'));
?>
<fieldset>
    <legend>过滤器</legend>
    <form method="POST" id="filter">
        <table style="margin:0;padding:0;">
            <tr>
                <?php
                    echo CHtml::tag('td', array(), '开始questId');
                    echo CHtml::tag('td', array(), CHtml::dropDownList('startQuestId', $filter['startQuestId'], CHtml::listData($allQuestIds, 'questId', 'text')));
                    echo CHtml::tag('td', array(), '结束questId');
                    echo CHtml::tag('td', array(), CHtml::dropDownList('endQuestId', $filter['endQuestId'], CHtml::listData($allQuestIds, 'questId', 'text')));
                    echo CHtml::tag('td', array(), '状态');
                    echo CHtml::tag('td', array(), CHtml::dropDownList('status', $filter['status'], CHtml::listData($statusType, 'value', 'text')));
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
<fieldset>
    <legend>
        Quest-Event：
        <input type="button" onclick="location.href='<?php echo $this->createUrl('questEvent/add');?>'" value="新  规">
    </legend>
    <div style="width:100%;height:20px;">
    <div style='position:absolute;right:250px;margin-bottom:7px;'>
        <?php
            array_walk($statusType, function($status, $key){
                if($key > 0){
                    echo CHtml::openTag('div', array('class'=>'cutline'));
                    $style = "background-color:" . $status['color'] . ";";
                    echo CHtml::tag('div', array('style'=>$style), '');
                    echo $status['text'];
                    echo CHtml::closeTag('div');
                }
            });
        ?>
    </div>
    </div>
    <?php //echo $this->renderPartial('page', array('pageInfo'=>$pageInfo, 'sourceUrl'=>$this->createUrl('questEvent/index'), 'id'=>''), true) ?>
    <table>
        <tr>
	        <th width="3%"></th>
	        <th width="5%">questId</th>
	        <th width="18%">questTitle</th>
	        <th width="12%">依赖主</th>
	        <th width="25%">说明文字</th>
	        <th width="10%">开始时间</th>
	        <th width="10%">结束时间</th>
	        <th width="7%">状态</th>
	        <th width="10%">操作</th>
        </tr>
        <?php
            $arguments = compact("statusType");
            array_walk($eventList, function($event, $key, $arguments){
                extract($arguments);
                $quest = $event['quest'];
                $status = $statusType[$event['status']];
                echo CHtml::openTag('tr', array('class'=>$status['color']));
                echo CHtml::tag('td', array(), CHtml::checkBox('selectedId[]', false, array('data-id'=>$event['id'])));
                echo CHtml::tag('td', array(), $quest['questId']);
                echo CHtml::tag('td', array(), $quest['questName']);
                echo CHtml::tag('td', array(), $quest['questClient']);
                echo CHtml::tag('td', array(), $quest['questStory']);
                echo CHtml::tag('td', array(), $event['startTime']);
                echo CHtml::tag('td', array(), $event['endTime']);
                echo CHtml::tag('td', array(), $status['text']);
                echo CHtml::openTag('td');
                echo CHtml::link('编辑', Yii::app()->controller->createUrl('questEvent/edit',array('eventId'=>$key)));
                echo CHtml::link('删除', "#_self", array('onclick'=>"deleteEvent($key)"));
                echo CHtml::closeTag('td');
                echo CHtml::closeTag('tr');
            }, $arguments);
        ?>
    </table>
    <div style="width:100%;height:20px;margin-top:10px;">
        <?php
            echo CHtml::htmlButton('全选', array('class'=>'selectAll'));
            echo CHtml::htmlButton('反选', array('class'=>'inverse'));
            echo CHtml::dropDownList('multiHandle', 0, CHtml::listData($multiHandleType, 'value', 'text'));
            echo CHtml::htmlButton('确定', array('class'=>'submit'));
        ?>
    </div>
    <?php //echo $this->renderPartial('page', array('pageInfo'=>$pageInfo, 'sourceUrl'=>$this->createUrl('questEvent/index'), 'id'=>''), true) ?>
</fieldset>
<br /><br /><br /><br /><br />
<script>
jQuery(document).ready(function(){
    jQuery('.selectAll').bind('click', function(){selectAll();});
    jQuery('.inverse').bind('click', function(){inverse();});
    jQuery('.submit').bind('click', function(){multiHandle();});
});

var selectAll = function(){
    jQuery("input[name='selectedId[]']").each(function(){
        $(this).attr('checked', true);
    });
}

var inverse = function(){
    jQuery("input[name='selectedId[]']").each(function(){
        var checked = $(this).attr('checked');
        $(this).attr('checked', !checked);
    });
}

var multiHandle = function(){
    var selectedIds = new Array();
    jQuery("input[name='selectedId[]']").each(function(){
        var checked = $(this).attr('checked');
        if(checked){
            selectedIds.push($(this).attr('data-id'));
        }
    });
    var handleType = parseInt(jQuery("#multiHandle").val());
    if(handleType == 0){
        alert('请选择操作类型');
        return false;
    }
    if(selectedIds.length==0){
        alert('请选择event');
        return false;
    }
    switch(handleType){
        case 1 : multiEdit(selectedIds);break;
        case 2 : multiDelete(selectedIds);break;
        default : break;
    }
}

var multiEdit = function(selectedIds){
    var url = "<?php echo $this->createUrl('questEvent/edit', array('eventId'=>'EventId'));?>";
    url = url.replace('EventId', selectedIds);
    window.location.href = url;
}

var multiDelete = function(selectedIds){
    var url = "<?php echo $this->createUrl('questEvent/delete', array('eventId'=>'EventId'));?>";
    url = url.replace('EventId', selectedIds);
	if(confirm("是否删除?")){
        SevenLoader.get(url, deleteCallBack);
    }
}

var deleteEvent = function(eventId){
	if(confirm("是否删除?")){
		 SevenLoader.get('<?php echo $this->createUrl('questEvent/delete');?>&eventId='+eventId, deleteCallBack);
	}
}

var deleteCallBack = function(res){
    window.location.reload();
}
</script>
