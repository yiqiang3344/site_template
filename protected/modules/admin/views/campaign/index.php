<style type='text/css'>
	span{font-size:20px;}
	li {font-size:15px;}
	form {font-size:15px;}
</style>

<form method="post" action="" enctype="multipart/form-data">	
	<input type="file" name="campaign">
	<!-- <span>campaignId:</span><input type='text' name='campaignId' id='campaignId' />	
	<span>campaignName:</span><input type='text' name='campaignName' id='campaignName' /> -->
	<input type="submit" name="submit" value="submit">
</form>
<hr>

<!-- <input type="hidden" value="0" id="loadType">
	<input type="radio" value="0" name="loadType" checked="checked" onclick="$('#elite').val(this.value);" /><span>url</span>
	<input type="radio" value="1" name="loadType" onclick="$('#elite').val(this.value);" /><span>xml</span>
<br>
<span>campaignId:</span><input type='text' id='campaignId' /><button onclick=getById();>getById</button>
<br>
<span>campaignName:</span><input type='text' id='campaignName' /><button onclick=getByName();>getByName</button> -->
<div id='campaign'>
<?php
	//$campaign->createXML();
	if (isset($content)) {
		echo $content;
	}
?>
</div>
