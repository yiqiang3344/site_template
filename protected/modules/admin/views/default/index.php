<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>
<p>
<?php echo CHtml::link('phpinfo', array('default/phpInfo'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('support', array('worldManager/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('TestPlayer', array('testPlayer/testPlayerList'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('BattleLog', array('battleLog/index', 'logId' => 1), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('BattleDamageLog', array('battleDamageLog/index', 'logId' => 1), array('target' => '_blank')); ?>
<br />
<?php echo CHtml::link('DevTool', array('devTool/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('FlushCache', array('default/flushCache'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('LanguageCompare', array('languageCompare/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('Data', array('data/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('BattleTest', array('battleTest/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('QuestTest', array('questTest/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('QuestSet', array('questSet/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('PlayerInfo', array('playerInfo/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('Campaign', array('campaign/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('area', array('area/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('QuestEvent', array('questEvent/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('YearEndEvent', array('yearEndEvent/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('Import Data', array('dataImport/index'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('Generate Config', array('dataImport/config'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('event migrate', array('dataImport/eventMigrate'), array('target' => '_blank')); ?><br />
<?php echo CHtml::link('tower tools', array('towerTools/index'), array('target' => '_blank')); ?><br />
</p>
