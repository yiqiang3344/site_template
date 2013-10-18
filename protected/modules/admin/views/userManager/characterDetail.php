<div class="line"></div>
<?php 
    if ($characterData['hasCharacter'] === true ) {
        $character = $characterData['character'];
?>
    <span class="titleMenu red"><?php echo Yii::t('AdminModule.UserManager', 'role information'); ?></span>
    <table width = "800px">
        <tr>
			<th><?php echo Yii::t('AdminModule.UserManager', 'ID'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'job'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'name'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'level'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'age'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'lifespan'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'growup time'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'status'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'life'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'attack'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'assist attack'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'indirect attack'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'defend'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'assist defend'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'restore'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'resore range'); ?></th>
			<th><?php echo Yii::t('AdminModule.UserManager', 'multiattack'); ?></th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td><?php echo $character->characterId; ?></td>
            <td><?php echo $character->getJobName(); ?></td>
            <td><?php echo Yii::t('Character', $character->firstName) . "&nbsp;&nbsp;" . Yii::t('Character', $character->lastName); ?></td>
            <td><?php echo $character->level; ?></td>
            <td><?php echo $character->age; ?></td>
            <td><?php echo $character->life; ?></td>
            <td><?php echo $character->growAge . '-' . $character->agingAge; ?></td>
            <td><?php echo '-' ?></td>
            <td><?php echo $character->getHp() . '/' . $character->getHpMax(); ?></td>
            <td><?php echo $character->getAttack(); ?></td>
            <td><?php echo $character->getAssistAttack(); ?></td>
            <td><?php echo $character->getIndirectAttack(); ?></td>
            <td><?php echo $character->getDefend(); ?></td>
            <td><?php echo $character->getAssistDefend(); ?></td>
            <td><?php echo $character->getRestore(); ?></td>
            <td><?php echo $character->getRestoreRange(); ?></td>
            <td><?php echo $character->getCri(); ?></td>
            <td><?php echo CHtml::link(Yii::t('AdminModule.UserManager', 'detail'), array('characterDetail')); ?></td>
        </tr>
    </table>
<?php 
    }
    else {
        echo Yii::t('AdminModule.UserManager', 'not find the player');
    }
?>
<div class="line"></div><div class="line"></div>
<?php echo CHtml::link(Yii::t('AdminModule.UserManager', 'return to userManager'), array('index')); ?>

