<div>
    <?php $armyIndexArray = array(0, 1, 2); ?>
    <table>
    <tr>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'town id'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'town name'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'area id'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'area name'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'importance'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'danger'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'fightingBar'); ?></th>
        <th rowspan = "2"><?php echo Yii::t('AdminModule.View', 'status'); ?></th>
        <th colspan = "<?php echo count($armyIndexArray); ?>"><?php echo Yii::t('AdminModule.View', 'garrison'); ?></th>
        <th rowspan = "2">&nbsp;</th>
    </tr>
    <tr>
        <?php 
            foreach ($armyIndexArray as $armyIndex) {
        ?>
        <th><?php echo Yii::t('AdminModule.View', 'army'); ?><?php echo $armyIndex + 1; ?></td>
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
            <td><?php echo $townStatusStrList['DB_STATUS_SHOW_PERFECT'][$town->status]; ?></td>
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
            <td><?php echo CHtml::link(Yii::t('AdminModule.View', 'detail'), array('townDetail', 'townId' => $town->townId)); ?></td>
        </tr>
    <?php } ?>
    </table>
</div>