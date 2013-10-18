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
$hours = range(0, 23);
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
            <td>task</td>
            <td><?php echo $form->fileField($model, 'task');?></td>
        </tr>
        <tr>
            <td>quest</td>
            <td><?php echo $form->fileField($model, 'quest');?></td>
        </tr>
        <tr>
            <td>fileName:</td>
            <td><?php echo $form->textfield($model, 'fileName');?></td>
        </tr>
        <tr>
            <td>startTime:</td>
            <td>
                <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
                        'attribute' => 'startTime1',
                        'model' => $model,
                        'options' => array(   
                            'dateFormat' => 'yy-mm-dd',   
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>'true',
                            'style' => 'text-align:center;',
                        ),
                    ));
                ?>
                <?php echo $form->dropDownList($model, 'startTime2', $hours);?>
            </td>
        </tr>
        <tr>
            <td>endTime:</td>
            <td>
                <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(   
                        'attribute' => 'endTime1',
                        'model' => $model,
                        'options' => array(   
                            'dateFormat' => 'yy-mm-dd',   
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>'true',
                            'style' => 'text-align:center;',
                        ),
                    ));
                ?>
                <?php echo $form->dropDownList($model, 'endTime2', $hours);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton();?></td>
        </tr>
    </table>
</fieldset>
<?php $this->endWidget();?>
