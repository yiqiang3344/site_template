<?php
    header("content-type:text/html;charset=utf-8");
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<style>
    table {width:50%;}
    td {text-align: center;	width: 20px; height:20px; border :1px solid #ccc;}
    #calendar .today{font-size:18px; font-weight:900;}
    #calendar .hasEvent{background-color:red;}
</style>
<fieldset class="">
	<legend>选择日期：</legend>
<?php
    $start_weekday = date('w',mktime(0,0,0,$month,1,$year));    
    $days = date('t',mktime(0,0,0,$month,1,$year));    
    $week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');    
    $k=1;
    for($start_year = 1970;$start_year<2039;$start_year++){   
        $years[$start_year] = array('value'=>$start_year, 'text'=>$start_year.'年');
    }
    for($start_month = 1;$start_month<=12;$start_month++){ 
        $months[$start_month] = array('value'=>$start_month, 'text'=>$start_month.'月');
    }    
    function lastYear($year,$month){     
    	$year = $year-1;
	    return Yii::app()->controller->createUrl('QuestSet/index', array('year'=>$year, 'month'=>$month)); 
    }    
    function lastMonth($year,$month){     
	    if($month == 1){      
		    $year = $year -1;      
    		$month = 12;     
	    }else{      
		    $month--;     
    	}     
	    return Yii::app()->controller->createUrl('QuestSet/index', array('year'=>$year, 'month'=>$month)); 
    }    
    function nextYear($year,$month){     
	    $year = $year+1;     
    	return Yii::app()->controller->createUrl('QuestSet/index', array('year'=>$year, 'month'=>$month)); 
    }    
    function nextMonth($year,$month){     
	    if($month == 12){      
		    $year = $year +1;      
    		$month = 1;     
	    }else {      
		    $month++;     
    	}     
	    return Yii::app()->controller->createUrl('QuestSet/index', array('year'=>$year, 'month'=>$month)); 
    }    
?>
<!-- //create calendar -->
<?php
    echo '<table border="1" id="calendar">';       
    echo CHtml::tag('tr', array(), CHtml::tag('td', array('colspan'=>7, 'style'=>"text-align:center"), $year.'年'.$month.'月'));
    echo '<tr>';    
    for($i = 0;$i < 7;$i++){        
        echo CHtml::tag('td', array(), $week[$i]);
    }
    echo '</tr>';    
    echo '<tr>';    
    for($j = 0;$j < $start_weekday;$j++){
    	echo CHtml::tag('td');    
    }    
    while($k <= $days){     
    	$class="";
	    if($k == date('d')){
            $class = 'today';
    	}
	    $dateStartTime = strtotime($year.'-'.$month.'-'.$k);
    	$hasEvent = $questQuery->getDateQuest($dateStartTime);
	    if(!empty($hasEvent)){
            $class .= ' hasEvent';
    	}
        echo CHtml::tag('td', array('class'=>ltrim($class)), CHtml::link($k, $this->createUrl('questSet/viewEvent',array('year'=>$year,'month'=>$month,'day'=>$k))));
    	if(($j+1) % 7 == 0){            
	    	echo '</tr><tr>';        
    	}        
	    $j++;        
    	$k++;    
    }    
    while($j % 7 != 0){
	    echo CHtml::tag('td');        
    	$j++;    
    }    
    echo '</tr>';       
    echo '<tr>';    
    echo CHtml::tag('td', array(), CHtml::link('<<', lastYear($year, $month)));
    echo CHtml::tag('td', array(), CHtml::link('<', lastMonth($year, $month)));
    echo '<td colspan = 3 style = "text-align:center">';      
    echo CHtml::dropDownList('year', $year, CHtml::listData($years, 'value', 'text'));
    echo CHtml::dropDownList('month', $month, CHtml::listData($months, 'value', 'text'));
    echo CHtml::tag('button', array('id'=>"searchButton"), '查询');
    echo '</td>';    
    echo CHtml::tag('td', array(), CHtml::link('>', nextMonth($year, $month)));
    echo CHtml::tag('td', array(), CHtml::link('>>', nextYear($year, $month)));
    echo '</tr>';    
    echo '</table>';
?>
<script>
jQuery("#searchButton").click(function(){
	var year = jQuery('#year option:selected').val();
	var month =jQuery('#month option:selected').val();
	location.href="<?php echo $this->createUrl('questSet/index');?>"+"&year="+year+"&month="+month;
});
</script>
</fieldset>

<fieldset class="">
    <?php $this->widget('application.modules.admin.components.widget.WeekEventQuest',array('time'=>time())); ?>
</fieldset>
