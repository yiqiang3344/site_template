<form method="post" action="<?php echo $this->createUrl('QuestTest/unlockAllQuest');?>">
	玩家id<input type="text" name="playerId" value="1">
	<input type="submit" value="解锁所有quest" name="button"/>
</form>
<br /><br />
<form method="post" action="<?php echo $this->createUrl('QuestTest/unlockARank');?>">
	<span>解锁指定rank中除最后一个quest的所有quest</span><br />
	玩家id<input type="text" name="playerId" value="1">
	rank id<input type="text" name="rankId" value="1">
	<input type="submit" value="解锁" name="button"/>
</form>


