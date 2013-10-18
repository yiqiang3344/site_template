<?php
foreach($quests as $key=>$quest){
    $quest['questTitle'] = $quest['questId'] . '、' . Yii::t('QuestName', $quest['questTitle']);
    $quests[$key] = $quest;
}
array_unshift($quests, array('questId'=>0, 'questTitle'=>'选择Quest:'));
echo CHtml::dropDownList('questId', 0, CHtml::listData($quests, 'questId', 'questTitle'));
?>
<input type="button" id="addQuestButton" value="添加quest"/>
<script>
jQuery('#addQuestButton').click(function(){
	var questId = jQuery("#questId").val();
	var innerText = jQuery("#questId").find("option:selected").text();
	if(questId >0){
		if ($("#quest_"+questId).length > 0) {
			alert('quest 已经存在~~');
		}else{
			jQuery('#questList').append('<li id="quest_'+questId+'">'+innerText+'<input type="hidden" name="selectedId[]" value="'+questId+'"/><input type="button" class="deleteQuestButton" onclick="jQuery(this).parent().remove();" value="删除"/></li>');
		}
	}else{
		alert('请选择quest~~');
	}
});
</script>
