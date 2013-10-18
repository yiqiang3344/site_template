<div class="line"></div>
<fieldset class="">
    <legend><?php echo Yii::t('AdminModule.UserManager', 'player research'); ?></legend>
    <?php echo Yii::t('AdminModule.UserManager', 'research pattern'); ?><select id="SPlayerType"><option value="id"><?php echo Yii::t('AdminModule.UserManager', 'player ID'); ?></option><option value="name"><?php echo Yii::t('AdminModule.UserManager', 'player name'); ?></option></select>
    <input class="w100" type="text" value="" id="SPlayerInput">
    <input type="button" value="<?php echo Yii::t('AdminModule.UserManager', 'search'); ?>" onClick="UMAction.searchPlayer()">
</fieldset>
<div class="line"></div>
<fieldset class="">
    <legend><?php echo Yii::t('AdminModule.UserManager', 'role research'); ?></legend>
    <?php echo Yii::t('AdminModule.UserManager', 'research pattern'); ?><select id="SCharacterType"><option value="id">
	<?php echo Yii::t('AdminModule.UserManager', 'role ID'); ?></option></select>
    <input class="w100" type="text" value="" id="SCharacterInput">
    <input type="button" value="<?php echo Yii::t('AdminModule.UserManager', 'search'); ?>" onClick="UMAction.searchCharacter()">
</fieldset>

<script language="javascript">
    window.UMAction = {
        searchPlayer:function() {
            var url = "<?php echo $this->createUrl('playerDetail');?>";
            url += "&type="+$("#SPlayerType").val()+"&data="+$("#SPlayerInput").val();
            location.href = url;
        },
        searchCharacter:function() {
            var url = "<?php echo $this->createUrl('characterDetail');?>";
            url += "&data="+$("#SCharacterInput").val();
            location.href = url;
        },
    }
</script>