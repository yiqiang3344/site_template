<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1>Data generation</h1>

<form method="post" action="" enctype="multipart/form-data">
	<select name="model">
		<option value="DataMonsterAI" selected="">monsterAI</option>
        <option value="DataCharacter">Character</option>
        <option value="DataJobCoRelation">JobCoRelation</option>
        <option value="DataPersonality">Personality</option>
        <option value="DataFamily">Family</option>
        <option value="DataSkill">Skill</option>
        <option value="DataMonsterBasic">monsterBasic</option>
        <option value="DataQuest">Quest</option>
        <option value="DataTask">Task</option>
        <option value="DataPlace">Place</option>
        <option value="DataQuestRankDrop">QuestRankDrop</option>
        <option value="DataRankBase">RankBaseSetting</option>
        <option value="DataUnionArmy">UnionArmy</option>
        <option value="DataUnionLv">UnionLv</option>
        <option value="DataUnionlvBase">UnionLvBase</option>
        <option value="DataUnionMonsterDrop">UnionMonsterDrop</option>
        <option value="DataUnionDrop">UnionDrop</option>
        <option value="DataUrgentQuestDrop">UrgentQuestDrop</option>
        <option value="DataEquipmentParam">EquipmentParam</option>
        <option value="DataEventQuest">EventQuest</option>
        <option value="DataEventTask">EventTask</option>
	</select>
	
	Please upload the csv file
	<input type="file" name="file">
	<input type="submit" name="submit" value="submit">
</form>
</p>


