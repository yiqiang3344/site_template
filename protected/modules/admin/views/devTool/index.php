<div class="line"></div>
<div class="line"></div>
<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send role'); ?></legend>
<?php
	echo Yii::t('AdminModule.DevTool', 'Template');
    echo CHtml::dropDownList('cTemplateId', '1', CHtml::listData($characterTemplates, 'characterTemplateId', 'templateName'));
?>
	等级<input class="w35" type="text" name="level" id="clevel" value="1" />
<?php
    echo CHtml::radioButtonList('rare', 0, $rares, array('separator'=>" "));
?>
	性格<select id="cpersonalityId"><?php foreach($personality as $record) {echo "<option value=$record[personalityId]>".$record['personalityId'].":".Yii::t('Personality', $record['name'])."</option>";} ?></select><br>
	<table><tr align='center'><th>技能</th><th>技能名称</th><th>技能等级</th></tr>
	<tr><td><?php echo Yii::t('AdminModule.DevTool', 'skill1');?></td><td><select id='skill1'>
		<option value=-1><?php echo Yii::t('AdminModule.DevTool', 'please select skill'); ?></option>
		<?php foreach ($skills as $key=>$skill) {?>
		    <option value=<?php echo $key+1;?>><?php echo ($key+1).':'.Yii::t('Skill', $skill);?></option>
		<?php }?>
	</select></td><td><input class="w35" type='text' name='skillLevel' id='slevel1' value=1></td></tr>
	<tr><td><?php echo Yii::t('AdminModule.DevTool', 'skill2');?></td><td><select id='skill2'>
		<option value=-2><?php echo Yii::t('AdminModule.DevTool', 'please select skill'); ?></option>
		<?php foreach ($skills as $key=>$skill) {?>
		    <option value=<?php echo $key+1;?>><?php echo ($key+1).':'.Yii::t('Skill', $skill);?></option>
		<?php }?>
	</select></td><td><input class="w35" type='text' name='skillLevel' id='slevel2' value=1></td></tr>
	<tr><td><?php echo Yii::t('AdminModule.DevTool', 'skill3');?></td><td><select id='skill3'>
		<option value=-3><?php echo Yii::t('AdminModule.DevTool', 'please select skill'); ?></option>
		<?php foreach ($skills as $key=>$skill) {?>
		    <option value=<?php echo $key+1;?>><?php echo ($key+1).':'.Yii::t('Skill', $skill);?></option>
		<?php }?>
	</select></td><td><input class="w35" type='text' name='skillLevel' id='slevel3' value=1></td></tr></table>
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="cplayerid" /> 
	<input type="button" value=" <?php echo Yii::t('AdminModule.DevTool', 'send role'); ?> " onClick="Action.sendCharacter()" />
	<?php echo Yii::t('AdminModule.DevTool', 'send one everytime'); ?>
</fieldset>

<div class="line"></div>

<?php
    $colors = array();
    for($i=1;$i<6;$i++){
        array_push($colors, array('value'=>$i, 'text'=>Yii::t("AdminModule.DevTool", "color$i")));
    }
?>

<?php
    $pveEquipments = array_filter($equipments, function($equipment){
        return $equipment['equipType'] == Equipment::EQUIP_TYPE_PVE;
    });
    array_unshift($pveEquipments, array('equipmentBaseId'=>0, 'equipmentName'=>'请选择'));
?>
<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send equipment to user'); ?></legend>
    <?php echo CHtml::dropDownList('equipid', '0', CHtml::listData($pveEquipments, 'equipmentBaseId', 'equipmentName'));?>
    <?php echo "开始";?>
    <?php echo CHtml::dropDownList('pveStartId', '0', CHtml::listData($pveEquipments, 'equipmentBaseId', 'equipmentBaseId'));?>
    <?php echo "结束";?>
    <?php echo CHtml::dropDownList('pveEndId', '0', CHtml::listData($pveEquipments, 'equipmentBaseId', 'equipmentBaseId'));?>
    <?php echo CHtml::dropDownList('color', '1', CHtml::listData($colors, "value", "text"));?>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w15" type="text" value="5" id="enumber" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'equipmentLevel'); ?><input class="w15" type="text" value="0" id="elv" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="eplayerid" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send equipment'); ?>" onClick="Action.sendEquip()">
</fieldset>

<?php
    $pvpEquipments = array_filter($equipments, function($equipment){
        return $equipment['equipType'] == Equipment::EQUIP_TYPE_PVP;
    });
    array_unshift($pvpEquipments, array('equipmentBaseId'=>0, 'equipmentName'=>'请选择'));
?>
<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send pvp equipment to user'); ?></legend>
    <?php echo CHtml::dropDownList('pvpequipid', '0', CHtml::listData($pvpEquipments, 'equipmentBaseId', 'equipmentName'));?>
    <?php echo "开始";?>
    <?php echo CHtml::dropDownList('pvpStartId', '0', CHtml::listData($pvpEquipments, 'equipmentBaseId', 'equipmentBaseId'));?>
    <?php echo "结束";?>
    <?php echo CHtml::dropDownList('pvpEndId', '0', CHtml::listData($pvpEquipments, 'equipmentBaseId', 'equipmentBaseId'));?>
    <?php echo CHtml::dropDownList('pvpcolor', '1', CHtml::listData($colors, "value", "text"));?>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w15" type="text" value="5" id="pvpenumber" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'equipmentLevel'); ?><input class="w15" type="text" value="0" id="pvpelv" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="pvpeplayerid" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send equipment'); ?>" onClick="Action.sendpvpEquip()">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send uitem to user'); ?></legend>
	<select id="itemid1">
		<?php foreach ($uitems as $key=>$value) {?>
		    <option value=<?php echo $key;?>><?php echo $key.':'.Yii::t('Item', $value['name']);?></option>
		<?php }?>
	</select>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w15" type="text" value="5" id="number1" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="playerId1" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send goods'); ?>" onClick="Action.sendItem(1)">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send citem to user'); ?></legend>
	<select id="itemid2">
		<?php foreach ($citems as $key=>$value) {?>
		    <option value=<?php echo $key;?>><?php echo $key.':'.Yii::t('Item', $value['name']);?></option>
		<?php }?>
	</select>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w15" type="text" value="5" id="number2" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="playerId2" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send goods'); ?>" onClick="Action.sendItem(2)">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send eitem to user'); ?></legend>
	<select id="itemid3">
		<?php foreach ($eitems as $key=>$value) {?>
		    <option value=<?php echo $key;?>><?php echo $key.':'.Yii::t('Item', $value['name']);?></option>
		<?php }?>
	</select>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w15" type="text" value="5" id="number3" /> 
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="playerId3" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send goods'); ?>" onClick="Action.sendItem(3)">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send money'); ?></legend>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w35" type="text" value="1000" id="money" />
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="mplayerid" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send money right now'); ?>" onClick="Action.sendMoney()">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send gold'); ?></legend>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w35" type="text" value="1000" id="gold" />
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="gplayerid" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send gold right now'); ?>" onClick="Action.sendGold()">
</fieldset>

<fieldset class="">
	<legend><?php echo Yii::t('AdminModule.DevTool', 'send FriendPoint'); ?></legend>
	<?php echo Yii::t('AdminModule.DevTool', 'amount'); ?><input class="w35" type="text" value="1000" id="fp" />
	<?php echo Yii::t('AdminModule.DevTool', 'playerID'); ?><input class="w35" type="text" value="<?php echo $this->playerId ;?>" id="fplayerid" /> 
	<input  type="button" value="<?php echo Yii::t('AdminModule.DevTool', 'send friendPoint right now'); ?>" onClick="Action.sendFP()">
</fieldset>
