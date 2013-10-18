<?php
$this->pageTitle=Yii::app()->name . ' - Battle Test';
$this->breadcrumbs=array(
	'Battle Test',
);
?>

<form method="post" action="">
	玩家id<input type="text" name="playerId" value="<?php echo $playerId?>">
	<?php
		$monsterList = MonsterBasic::getAll();
	?>
	怪物id<select name="monsterBasicId">
		<?php 
			foreach($monsterList as $monster){
				echo '<option value='.$monster['monsterBasicId'].' ';
				if($monsterBasicId == $monster['monsterBasicId']){
					echo 'selected';
				}
				echo '>'.$monster['monsterBasicId'].':'.Yii::t('Monster', $monster['monsterName']).'</option>';
			}
		?>
	</select>
	怪物等级<input type="text" name="monsterLevel" value="<?php echo $monsterLevel?>">
	<input type="submit" name="enterBattle" value="进入战斗">
	<input type="submit" name="showResult" value="显示结果">
</form>

<b><?php echo $result;?></b>