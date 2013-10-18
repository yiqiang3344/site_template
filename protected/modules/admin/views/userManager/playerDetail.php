<div class="line"></div>
<?php 
    if ($playerData['hasPlayer'] === true ) {
?>
    <div>
        <span class="titleMenu red"><?php echo Yii::t('AdminModule.UserManager', 'player information'); ?></span>
        <table width = "800px">
            <tr>
                <th width = "10%"><?php echo Yii::t('AdminModule.UserManager', 'player ID'); ?></th>
                <th width = "15%"><?php echo Yii::t('AdminModule.UserManager', 'player name'); ?></th>
                <th width = "10%"><?php echo Yii::t('AdminModule.UserManager', 'reputation level'); ?></th>
                <th width = "25%"><?php echo Yii::t('AdminModule.UserManager', 'located area'); ?></th>
                <th width = "25%"><?php echo Yii::t('AdminModule.UserManager', 'located town'); ?></th>
                <th width = "15%"><?php echo Yii::t('AdminModule.UserManager', 'money'); ?></th>
            </tr>
            <tr>
                <td><?php echo $playerData['player']->playerId; ?></td>
                <td><?php echo $playerData['player']->playerName; ?></td>
                <td><?php echo $playerData['player']->reputationLevel; ?></td>
                <td><?php $area = Yii::app()->objectLoader->load('Area', $playerData['player']->areaId); echo Yii::t('Area', $area->areaName); ?></td>
                <td><?php $town = Yii::app()->objectLoader->load('Town', $playerData['player']->townId); echo Yii::t('Town', $town->townName); ?></td>
                <td><?php echo $playerData['player']->gold; ?></td>
            </tr>
        </table>
    </div>
    <div class="line"></div>
    <div>
        <span class="titleMenu red"><?php echo Yii::t('AdminModule.UserManager', 'knight information'); ?></span>
        <table width = "800px">
            <tr>
                <th width = "10%"><?php echo Yii::t('AdminModule.UserManager', 'role MAX'); ?></th>
                <th width = "10%"><?php echo Yii::t('AdminModule.UserManager', 'current role number'); ?></th>
                <th width = "28%"><?php echo Yii::t('AdminModule.UserManager', 'leader'); ?></th>
                <th width = "13%"><?php echo Yii::t('AdminModule.UserManager', 'totalAttack'); ?></th>
                <th width = "13%"><?php echo Yii::t('AdminModule.UserManager', 'totalDefend'); ?></th>
                <th width = "13%"><?php echo Yii::t('AdminModule.UserManager', 'total Morale'); ?></th>
                <th width = "13%"><?php echo Yii::t('AdminModule.UserManager', 'total Restore'); ?></th>
            </tr>
            <tr>
                <td><?php echo $playerData['player']->knights->maxCharacterNum; ?></td>
                <td><?php echo ($playerData['player']->knights->characterNum('main') + $playerData['player']->knights->characterNum('sub')); ?></td>
                <td><?php if ($playerData['player']->knights->leaderId == 0) {echo Yii::t('AdminModule.UserManager', 'no leader');} else {$leader = Yii::app()->objectLoader->load('Character', $playerData['player']->knights->leaderId); echo Yii::t('Character', $leader->firstName) . "&nbsp;&nbsp;" . Yii::t('Character', $leader->lastName) . "【" . $playerData['player']->knights->leaderId . "】";} ?></td>
                <td><?php echo $playerData['player']->knights->totalAttack; ?></td>
                <td><?php echo $playerData['player']->knights->totalDefend; ?></td>
                <td><?php echo $playerData['player']->knights->totalMorale; ?></td>
                <td><?php echo $playerData['player']->knights->totalRestore; ?></td>
            </tr>
        </table>
    </div>
    <div class="line"></div>
    <div>
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
            <?php foreach ($playerData['characterList'] as $character) { ?>
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
                <td><?php echo CHtml::link(Yii::t('AdminModule.UserManager', 'detail'), array('characterDetail', 'data' => $character->characterId)); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php 
    }
    else {
        echo Yii::t('AdminModule.UserManager', 'not find the player');
    }
?>
<div class="line"></div><div class="line"></div>
<?php echo CHtml::link(Yii::t('AdminModule.UserManager', 'return to userManager'), array('index')); ?>

