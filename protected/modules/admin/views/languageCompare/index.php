<fieldset class="" style="width:400px;margin-left:200px;margin-top:100px; ">
    <legend><?php echo Yii::t('AdminModule.LanguageCompare', 'languageCompare'); ?></legend>
    <select id="PreLanguage"><option value="ja"><?php echo Yii::t('AdminModule.LanguageCompare', 'japanese'); ?></option><option value="en"><?php echo Yii::t('AdminModule.LanguageCompare', 'english'); ?></option></select>

	<select id="NextLanguage"><option value="ja"><?php echo Yii::t('AdminModule.LanguageCompare', 'japanese'); ?></option><option value="en"><?php echo Yii::t('AdminModule.LanguageCompare', 'english'); ?></option></select>
    <input type="button" value="<?php echo Yii::t('AdminModule.LanguageCompare', 'compare'); ?>" onClick="LCAction.languageCompare()">
</fieldset>


<script language="javascript">
    window.LCAction = {
        languageCompare:function() {
            var url = "<?php echo $this->createUrl('compareResult');?>";
            url += "&preLan="+$("#PreLanguage").val()+"&nextLan="+$("#NextLanguage").val();
            location.href = url;
        },

    }
</script>