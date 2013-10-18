<style>
table {border-width:1px; border-color:black; border-collapse:collapse;width:300px;font-size:20px;width:400px;}
table tr {height:30px;text-align:center;}
.text {width:150px;height:20px;}
.content {border:1px solid #C9E0ED;width:850px;height:100px;-webkit-user-select:text;}
button {height:30px;width:60px;margin-top:5px;}
.sql {font-size:20px;margin:10px;}
</style>
<?php $form = $this->beginWidget('CActiveForm', array('id'=>'YearEndEventForm',)); ?>
<?php echo $form->errorSummary($model); ?>
<table border=1>
    <tr>
        <td><?php echo $form->labelEx($model, 'questId')?></td>
        <td><?php echo $form->textField($model, 'questId', array('class'=>'text questId'));?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'globalAccumulateNum')?></td>
        <td><?php echo $form->textField($model, 'globalAccumulateNum', array('class'=>'text globalAccumulateNum'));?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'rank')?></td>
        <td><?php echo $form->textField($model, 'rank', array('class'=>'text rank'));?></td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'insertFlag')?></td>
        <td><?php echo $form->radioButtonList($model, 'insertFlag', array('0'=>'no', '1'=>'yes'), array('separator'=>'&nbsp;&nbsp'));?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::submitButton('提交');?></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<div class='content'>
<div class='sql'>
    <?php
    if(isset($sql)){
        echo $sql;
    }
    ?>
</div>
</div>
<button onclick="copySql()">copy</button>
<script type='text/javascript'>
function copySql(){
    var sql = jQuery(".sql").html();
    CopyToClipboard(sql);
}
function CopyToClipboard (value) {
    var textToClipboard = value;

    var success = true;
    if (window.clipboardData) { // Internet Explorer
        window.clipboardData.setData ("Text", textToClipboard);
    }else {
        // create a temporary element for the execCommand method
        var forExecElement = CreateElementForExecCommand (textToClipboard);

        /* Select the contents of the element 
       (the execCommand for 'copy' method works on the selection) */
        SelectContent (forExecElement);

        var supported = true;

        // UniversalXPConnect privilege is required for clipboard access in Firefox
        try {
            if (window.netscape && netscape.security) {
                netscape.security.PrivilegeManager.enablePrivilege ("UniversalXPConnect");
            }

            // Copy the selected content to the clipboard
            // Works in Firefox and in Safari before version 5
            success = document.execCommand ("copy", false, null);
        }catch (e) {
            success = false;
        }

        // remove the temporary element
        document.body.removeChild (forExecElement);
    }

    if (success) {
        alert ("The text is on the clipboard, try to paste it!");
    }else {
        alert ("Your browser doesn't allow clipboard access!");
    }
}

function CreateElementForExecCommand (textToClipboard) {
    var forExecElement = document.createElement ("div");
    // place outside the visible area
    forExecElement.style.position = "absolute";
    forExecElement.style.left = "-10000px";
    forExecElement.style.top = "-10000px";
    // write the necessary text into the element and append to the document
    forExecElement.textContent = textToClipboard;
    document.body.appendChild (forExecElement);
    // the contentEditable mode is necessary for the  execCommand method in Firefox
    forExecElement.contentEditable = true;

    return forExecElement;
}

function SelectContent (element) {
    // first create a range
    var rangeToSelect = document.createRange ();
    rangeToSelect.selectNodeContents (element);

    // select the contents
    var selection = window.getSelection ();
    selection.removeAllRanges ();
    selection.addRange (rangeToSelect);
}
</script>
