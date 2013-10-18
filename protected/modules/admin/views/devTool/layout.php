<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dev Tools</title>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/js/jquery-1.5.2.min.js"></script>
<style>
body {
	font-size:12px; margin:0; padding:0; text-align:center; text-align:center;
}
ul,li,p {
	margin:0; padding:0;
}
.block {
	width:950px; height:auto; margin:auto; clear:both;
}
fieldset {
	color:#666; margin-top:10px; display:block; text-align:left;
}
legend {
	font-weight:bold; color:#360; text-align:left;
}
a {
	padding:5px; color:#666; text-decoration:underline ;
}
a:hover{
	color:#F00;
}
.checked {
	background-color:#E9EFCB;
}
.line {
	width:100%; height:10px; clear:both;
}
.fl {
	float:left;
}
.fr {
	float:right;
}
.w450 {
	width:445px;
}
.w15 {
	width:15px;
}
.w35 {
	width:35px;
}
.dialogcontent {
	 overflow-y:scroll; border:solid 5px #ddd;
}

</style>
</head>
<body <?php $background = ModuleUtil::loadconfig('admin', 'background'); if($background['SHOW_BACKGROUND_COLOR'] == 1){ ?> style="background-color:<?php echo $background['BACKGROUND_COLOR'] ?>" <?php } ?>>
<div class="block">
<?php echo $content; ?>
</div>
<div class="line"></div>
<div class="block">
<fieldset>
	<legend><?php echo Yii::t('AdminModule.DevTool', 'other links'); ?></legend>
	<a href="/dev_tools/pma/" target="_blank"><?php echo Yii::t('AdminModule.DevTool', 'database tool'); ?></a> 
	<a href="/dev_tools/memcache.php" target="_blank"><?php echo Yii::t('AdminModule.DevTool', 'MemCache tool'); ?></a> 
</fieldset>
</div>

<script language="javascript">
$(document).ready(function(){
	$("fieldset").mouseover(function(){
		$(this).addClass('checked');
	}).mouseout(function(){
		$(this).removeClass('checked');
	});	
	
	
	//$("input").focus(function(){$(this).blur();});
	$("a").focus(function(){$(this).blur();});
});
window.dealReturnData = function(data){
	var dataId = 'retunDataArea';
	SevenDialog.create(dataId);
	$('#'+dataId).hide();
	
	SevenDialog.alert(data,'',<?php echo Yii::t('AdminModule.DevTool', 'shut down'); ?>,dataId);
	//var top = Math.max(Math.floor( ($(document).height()-$('#retunDataArea>.data').height())/2-100 ),20);
	var top = 50;
	$('#retunDataArea>.data').css('width','800px').css('margin-top',top+'px');
	$('#retunDataArea>.data>.content').css('width','90%').css('height','600px').css('margin-top','3px').addClass('dialogcontent');
	$('#'+dataId).show();
}


window.Action = {
	genCharacter:function(){
		var url = '?r=admin/devTool/character';
		url += '&jobid='+$('#jobid').val();
		url += '&num='+parseInt($('#cnumber').val()) ;
		url += '&elite='+$('#elite').val();
		//alert(url); 
		SevenLoader.get(url,'dealReturnData');
	},
	sendCharacter:function(){
		var url = '?r=admin/devTool/sendcharater&do=send';
		url += '&templateid='+$('#cTemplateId').val();
		url += '&rare='+($('input:radio[name=rare]:checked').val());
		url += '&playerid='+parseInt($('#cplayerid').val()) ;
		url += '&level='+$('#clevel').val();
		url += '&personalityId='+$('#cpersonalityId').val();
		url += '&skill1='+$('#skill1').val();
		url += '&skill2='+$('#skill2').val();
		url += '&skill3='+$('#skill3').val();
		url += '&slv1='+$('#slevel1').val();
		url += '&slv2='+$('#slevel2').val();
		url += '&slv3='+$('#slevel3').val();
		//alert(url); 
		SevenLoader.get(url);
	},
	sendEquip:function(){
		var url = '?r=admin/devTool/equip';
		url += '&itemid='+$('#equipid').val();
		url += '&startId='+$('#pveStartId').val();
		url += '&endId='+$('#pveEndId').val();
		url += '&num='+parseInt($('#enumber').val());
		url += '&elv='+parseInt($('#elv').val());
		url += '&color='+parseInt($('#color').val());
		url += '&playerid='+parseInt($('#eplayerid').val()) ;
		
		SevenLoader.get(url);
	} ,
	sendpvpEquip:function(){
		var url = '?r=admin/devTool/equip';
		url += '&itemid='+$('#pvpequipid').val();
		url += '&startId='+$('#pvpStartId').val();
		url += '&endId='+$('#pvpEndId').val();
		url += '&num='+parseInt($('#pvpenumber').val());
		url += '&elv='+parseInt($('#pvpelv').val());
		url += '&color='+parseInt($('#pvpcolor').val());
		url += '&playerid='+parseInt($('#pvpeplayerid').val()) ;
		
		SevenLoader.get(url);
	} ,
	sendItem:function(type){
		var url = '?r=admin/devTool/item';
		url += '&itemid='+$('#itemid'+type).val();
		url += '&num='+parseInt($('#number'+type).val()) ;
		url += '&playerid='+parseInt($('#playerId'+type).val()) ;
		url += '&type='+type ;
		
		SevenLoader.get(url);
	} ,
	sendMoney:function(){
		var url = '?r=admin/devTool/money';
		url += '&money='+$('#money').val();
		url += '&playerid='+parseInt($('#mplayerid').val()) ;
		
		SevenLoader.get(url);
	} ,
	sendGold:function(){
		var url = '?r=admin/devTool/gold';
		url += '&gold='+$('#gold').val();
		url += '&playerid='+parseInt($('#gplayerid').val()) ;
		
		SevenLoader.get(url);
	} ,
	sendFP:function(){
		var url = '?r=admin/devTool/sendFP';
		url += '&fp='+$('#fp').val();
		url += '&playerid='+parseInt($('#fplayerid').val());
		SevenLoader.get(url);
	},
	attributeRate:function(){
		var url = '?r=admin/devTool/rate&do=attribute';
		url += '&townid='+$('#townid').val();
		SevenLoader.get(url);
	} ,
	jobRate:function(){
		var url = '?r=admin/devTool/rate&do=job';
		url += '&townid='+$('#townid').val();
		SevenLoader.get(url);
	} 
	
}

window.Seven = {
	
	/** list all variables from a element **/
	dump:function(elem){
		var str = '';
		if( typeof(elem)=='object' )
			for( t in elem ) str+='['+t+'] => '+elem[t]+';\n';
		else 
			str = elem ;

		SevenDialog.alert(str);
	} ,

	error:function(message) {
		SevenDialog.alert(message);
	} ,
	
	run:function(string,encode) {
		if( encode ) string = this.decode(string);
		try {
			eval(string);
		}
		catch(e){
			this.dump(e);
			//SevenDialog.alert(string);
		}	
	},
	encode:function(string){
		return encodeURI(string);
	},
	decode:function(string){
		return decodeURI(string);	
	},
	isset:function(element) {
		return typeof(element)!='undefined';
	},
	empty:function(element) {
		return typeof(element)=='undefined'||element==false||element==null;
	}
	
}

/**
 * Seven common dialog actions.
 * such as alert use "SevenDialog.alert('Mission complete!')"
 */
window.SevenDialog = {
	elements:[],
	defaultElement :'SevenDialogMain',
	zIndex: 10 ,
	confirmValue:'OK',
	cancelValue:'Cancel',
	showCover : true ,
	alert:function( message,action,confirmValue,elemId ){
		if( !Seven.empty(confirmValue) ) this.confirmValue = confirmValue ;
		if( Seven.empty(elemId) ) elemId = this.defaultElement ;
		this.create(elemId);
		this.setContent(message,elemId,action);
		//alert(message);
	},
	
	close:function(elemId){
		if( Seven.isset(elemId) ){
			this.remove(elemId);
		}
		else {
			for( k in this.elements ) {
				if( !this.elements[k] ) continue ;
				this.remove(this.elements[k]);
			}	
		}
	},
	setContent:function(content,elemId,action){
		var actionData = 'SevenDialog.close(\''+elemId+'\'); Seven.run(\''+Seven.encode(action)+'\',true);';
		var htmlData = '';
		if( this.showCover ) {
			htmlData += '<div style="position:absolute; width:100%; height:100%; top:0; left:0; background-color:#000000; opacity:0.5;"></div>';
		}
		htmlData += '<div class="data" style="position:relative; width:280px; min-height:80px; height:auto;  background-color:#FFF; border:solid 2px #06F; margin:auto; margin-top:20%;">' +
				'<div class="content" style="width:80%; margin:auto; height:auto; line-height:18px; margin-top:10px; clear:both ; text-align:left; color:#333; " >'+content+'</div>' +
				'<div class="buttons" style="width:100%; height:20px; line-height:20px; margin-top:15px; margin-bottom:10px; clear:both; text-align:center;"><input type="button" value="'+this.confirmValue+'" onclick="'+actionData+'"></div>' +
				//'<div class="close" style="position:absolute; right:3px; top:3px; border:solid 1px #ccc; width:12px; height:12px; cursor:pointer; font-size:10px;" onclick="SevenDialog.close(\''+elemId+'\');">X</div>' +
			'</div>';
		$('#'+elemId).html(htmlData);
	},
	create:function(elemId,content) {
		if( $('#'+elemId).attr('id')==elemId ) {
			$('#'+elemId).css('z-index',this.zIndex++);
			return true ;
		}
		var element = document.createElement("div");
		$(element).attr('id',elemId).attr('style','position:absolute; top:0; width:100%; height:100%; left:0px; text-align:center; display:block; z-index:'+(this.zIndex++)+';');
		//if( !this.showCover )$(element).css('height','1px');
		if( !Seven.empty(content) ) $(element).html(content);
		$('body').append(element);
		this.elements[elemId] = elemId ; 
	},
	remove:function(elemId){
		if( !$('#'+elemId) ) return true ;
		$('#'+elemId).remove();
		this.elements[elemId] = false ;  
	}

}


window.SevenLoader = {
	dataType : 'json' ,
	callBackFunc : '' ,
	dataelemId: '' ,
	get:function(url,callback){
		if( !Seven.empty(callback) ) {
			this.callBackFunc = callback;
		}
		else {
			this.callBackFunc = '';	
		}
		url += '&isAjax=1&t='+Math.floor(Math.random()*10000000);

		$.get(url,'',this.commonCallBack,this.dataType) ;
	},
	show : function(url,elemId){
		if( elemId ) {
			this.dataelemId = elemId;
		}
		else {
			this.dataelemId = '';
		}
		this.get(url);
	},

	/** Ajax callback function. **/
	commonCallBack : function(ret){
		if( ret.stateCode == 1 ) {
			if( SevenLoader.callBackFunc ) {
				try {
					eval(SevenLoader.callBackFunc+'(ret.data);');
				}
				catch(e) {
					SevenDialog.alert('Return data error.');
				}
			}
			else {
				SevenLoader.commonDeal( ret.data );
			}
		}
		else if( ret.stateCode == 2 ) {
			SevenDialog.alert(ret.message,ret.data,false,'DialogRequestSuccess');
		}
		else {
			SevenDialog.alert(ret.stateCode+':'+ret.message);
		}
	} , 

	/** data show function **/
	commonDeal : function(data) {
		if( SevenLoader.dataelemId!='' ) {
			$('#'+SevenLoader.dataelemId).html(data);
		}
		else {
			SevenDialog.alert(data);
		}
	}

}


</script>
</body>
</html>
