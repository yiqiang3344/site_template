<?php
$style = <<<IMPORT
    legend {font-size:15px;}
    table {font-size:15px;}
    table tr {height:20px;}
    .sqlContent {
        font-family: Monaco, DejaVu Sans Mono, Bitstream Vera Sans Mono, Consolas, Courier New, monospace;
        font-size: 13px;
        background-color: transparent;
        width: 99%;
        overflow: auto;
        margin-left: 9px;
        padding: 1px; /* adds a little border on top when controls are hidden */
        word-break: break-all;
        word-wrap: break-word;
        -webkit-user-select:text;
    }
    .sqlContent ol {
        border: 1px solid #D1D7DC;  
        list-style: decimal; /* for ie */
        background-color: #fff;
        margin: 0px 0px 1px 0px; /* 1px bottom margin seems to fix occasional Firefox scrolling */
        padding: 2px 0;
        padding-left:6px;
        color: #2B91AF;
    }
    ol {
        font-size: 1.0em;
        line-height: 1.4em;
        margin: 0 0 1.5em 0;
        padding: 0;
    }
    ol li {
        font-size: 1.0em;
        margin: 0 0 0.25em 30px;
        border-bottom:1px solid #D1D7DC;
        padding: 0;
    }
    .sqlContent ol li {
        border-left: 1px solid #D1D7DC;
        background-color: #FAFAFA;
        padding-left: 10px;
        line-height: 18px;
        margin: 0 0 0 38px;
    }
    .sqlContent ol li span {
        color: Black;
    }
    .sqlContent .keyword {
        color: #7f0055;
        font-weight: bold;
    }
    fieldset {
        #border:2px groove threedface;
    }
IMPORT;
Yii::app()->clientScript->registerCss("import", $style);
?>
<?php
$modelName = get_class($model);
$form = $this->beginWidget('CActiveForm',
    array(
        'id'=>get_class($model),
        'htmlOptions' => array(
            'enctype'=>"multipart/form-Data"
        ),
    )
);
?>
<?php echo $form->errorSummary($model);?>
<fieldset>
    <legend>Import Data</legend>
    <table>
        <tr>
            <td>上传文件</td>
            <td><?php echo $form->fileField($model, 'uploadfile');?></td>
        </tr>
        <tr>
            <td>选择模型</td>
            <td><?php echo $form->dropDownList($model, 'modelName', CHtml::listData($model->getModelList(), 'value', 'text'));?></td>
        </tr>
        <tr>
            <td>数据类型</td>
            <td>
                <?php
                    echo $form->radioButtonList($model, 'dataType',
                        array($modelName::DATA_INSERT=>"INSERT", $modelName::DATA_CONFIG=>"CONFIG", $modelName::DATA_UPDATE=>"UPDATE"),
                        array('separator'=>"&nbsp;&nbsp;&nbsp;&nbsp;")
                    );
                ?>
            </td>
        </tr>
        <tr>
            <td>更新字段</td>
            <td><?php echo $form->textField($model, 'updateColumns');?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton();?></td>
        </tr>
    </table>
</fieldset>
<?php $this->endWidget();?>
<div id='preview' class='sqlContent'>
<?php
if(isset($sql)){?>
<?php
    echo $sql;
}
?>
</div>
<?php
if(isset($copy)){
    $jsCopy = CJSON::encode($copy);
    $script = <<<__SCRIPT__
        window.copy = $jsCopy;
        function copyToClipboard(text){
            if (window.clipboardData) // Internet Explorer
            {  
                alert(1);
                window.clipboardData.setData("Text", text);
            }else{  
                alert(2);
                unsafeWindow.netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
                const clipboardHelper = Components.classes["@mozilla.org/widget/clipboardhelper;1"].getService(Components.interfaces.nsIClipboardHelper);  
                clipboardHelper.copyString(text);
            }
        }
        copyToClipboard(copy);
__SCRIPT__;
    //Yii::app()->clientScript->registerScript("copy", $script);
}
?>
