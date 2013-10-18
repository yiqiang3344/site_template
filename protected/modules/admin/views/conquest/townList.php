<?php $armyIndexArray = array(0, 1, 2); ?>
<div>
    <table>
    <tr>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'town ID'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'town name'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'area ID'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'area name'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'important level'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'dangerous value'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'strategic value'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.Conquest', 'status'); ?></th>
        <th colspan = "<?php echo count($armyIndexArray); ?>"><?php echo Yii::t('AdminModule.Conquest', 'garrison'); ?></th>
        <th rowspan = "2">&nbsp;</th>
    </tr>
    <tr>
        <?php 
            foreach ($armyIndexArray as $armyIndex) {
        ?>
        <th><?php echo Yii::t('AdminModule.Conquest', 'army'); ?><?php echo $armyIndex + 1; ?></td>
        <?php 
            }
        ?>
    </tr>
    <?php 
        $townStatusStrList = Util::loadconfig('townStatus');
        foreach ($dataList as $data) {
            $town = $data['town'];
            $armyList = $data['armyList'];
            $area = $data['area'];
    ?>
        <tr>
            <td><?php echo $town->townId; ?></td>
            <td><?php echo Yii::t('Town', $town->townName); ?></td>
            <td><?php echo $town->areaId; ?></td>
            <td><?php echo Yii::t('Area', $area->areaName); ?></td>
            <td><?php echo $town->importance; ?></td>
            <td><?php echo $town->danger . '/' . $town->dangerMax; ?></td>
            <td><?php echo $town->fightingBar . '/' . $town->fightingBarMax; ?></td>
            <td><?php echo $townStatusStrList[$town->getTownStatus()]; if ($town->status > 3) {echo '('. $townStatusStrList[$town->status - 4] .')';} ?></td>
            <?php 
                foreach ($armyIndexArray as $armyIndex) {
            ?>
                <td><?php 
                        if (isset($armyList[$armyIndex])) {
                            echo Yii::t('Army', $armyList[$armyIndex]->armyName);
                        }
                        else {
                            echo "&nbsp;";
                        }
                ?></td>
            <?php 
                }
            ?>
            <td><?php echo CHtml::link(Yii::t('AdminModule.Conquest', 'detail'), array('townDetail', 'townId' => $town->townId), array('target' => '_blank')); ?></td>
        </tr>
    <?php } ?>
    </table>
</div>