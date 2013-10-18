<style>
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
</style>
<h1>Import Data</h1>
<form action='' method='POST' enctype="multipart/form-data">
    <table>
        <tr>
            <td>上传文件</td>
            <td><input type="file" name="file" id='file'></td>
        </tr>
        <tr>
            <td>选择模型:</td>
            <td><?php echo CHtml::dropDownList('modelName', 0, CHtml::listData($modelList, 'value', 'text'));?></td>
        </tr>
        <tr>
            <td>args:</td>
            <td><?php echo CHtml::textField('args');?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>
</form>
<div id='preview' class='sqlContent'>
<pre>
<?php
if(isset($html)){
    echo htmlspecialchars($html);
}?>
</pre>
</div>
<script type='text/javascript'>
</script>
