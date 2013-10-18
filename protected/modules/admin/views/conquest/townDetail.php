<?php $townStatusStrList = Util::loadconfig('townStatus'); ?>
<div>
    </br>
    <div style="background-color:#FFFF99;">
        <h3><?php echo Yii::t('AdminModule.Conquest', 'town information'); ?>（<?php echo Yii::t('Town', $town->townName); ?>）</h3>
        <table width = "720px">
            <tr>
                <th width = "10%"><?php echo Yii::t('AdminModule.Conquest', 'town ID'); ?></th><td width = "15%"><?php echo $town->townId; ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.Conquest', 'town name'); ?></th><td width = "15%"><?php echo Yii::t('Town', $town->townName); ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.Conquest', 'area ID'); ?></th><td width = "15%"><?php echo $town->areaId; ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.Conquest', 'area name'); ?></th><td width = "15%"><?php echo Yii::t('Area', $area->areaName); ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('AdminModule.Conquest', 'important level'); ?></th><td><?php echo $town->importance; ?> <input type="button" class="btn" value="变更" name="changeImportance"></td>
                <th><?php echo Yii::t('AdminModule.Conquest', 'dangerous value'); ?></th><td><?php echo $town->danger . '/' . $town->dangerMax; ?><input type="button" class="btn" value="+" name="refreshDanger"></td>
                <th><?php echo Yii::t('AdminModule.Conquest', 'strategic value'); ?></th><td><input type="button" class="btn" value="-" name="changeFightingBar"><?php echo $town->fightingBar . '/' . $town->fightingBarMax; ?><input type="button" class="btn" value = "+" name="changeFightingBar"></td>
                <th><?php echo Yii::t('AdminModule.Conquest', 'status'); ?></th><td><?php echo $townStatusStrList[$town->getTownStatus()]; if ($town->status > 3) {echo '('. $townStatusStrList[$town->status - 4] .')';} ?></td>
            </tr>
        </table>
    </div>
    <br>
    <div style="background-color:#FFCCCC;">
        <h3><?php echo Yii::t('AdminModule.Conquest', 'monster group information'); ?></h3>
        <?php 
            foreach ($armyList as $armyDetail) {
                $army = $armyDetail['army'];
                $bossList = $armyDetail['generalBoss'];
                $monsterList = $armyDetail['monster'];
        ?>
        <div>
            <table width = "720px">
                <tr>
                    <th colspan = "6"><?php echo Yii::t('AdminModule.Conquest', 'basic property'); ?></th>
                </tr>
                <tr>
                    <th width = "15%"><?php echo Yii::t('AdminModule.Conquest', 'army ID'); ?></th><td width = "15%"><?php echo $army->armyId; ?></td>
                    <th width = "15%"><?php echo Yii::t('AdminModule.Conquest', 'army name'); ?></th><td width = "25%"><?php echo Yii::t('Army', $army->armyName); ?></td>
                    <th width = "15%"><?php echo Yii::t('AdminModule.Conquest', 'strategic decrease value'); ?></th><td width = "15%"><?php echo $army->fightingBar; ?></td>
                </tr>
            </table>
            <table width = "720px">
                <tr>
                    <th colspan = "5" style = "border-top:none;"><?php echo Yii::t('AdminModule.Conquest', 'general information'); ?></th>
                </tr>
                <tr>
                    <th width = "10%"><?php echo Yii::t('AdminModule.Conquest', 'serial number'); ?></th>
                    <th width = "15%"><?php echo Yii::t('AdminModule.Conquest', 'monster ID'); ?></th>
                    <th width = "30%"><?php echo Yii::t('AdminModule.Conquest', 'monster name'); ?></th>
                    <th width = "15%"><?php echo Yii::t('AdminModule.Conquest', 'monster level'); ?></th>
                    <th width = "30%"><?php echo Yii::t('AdminModule.Conquest', 'monster status'); ?></th>
                </tr>
                <?php 
                    foreach ($bossList as $index => $boss) {
                        $bossStatusStr = array(
                            ARMY_GENERAL_BOSS_STATUS_WAITING => Yii::t('AdminModule.Conquest', 'waiting'),
                            ARMY_GENERAL_BOSS_STATUS_FIGHTING => Yii::t('AdminModule.Conquest', 'fighting'),
                            ARMY_GENERAL_BOSS_STATUS_WIN => Yii::t('AdminModule.Conquest', 'win'),
                            ARMY_GENERAL_BOSS_STATUS_LOSE => Yii::t('AdminModule.Conquest', 'lose'),
                        );
                        $bossStatus = $boss['stat'];
                        if (($bossStatus == ARMY_GENERAL_BOSS_STATUS_FIGHTING) and ($boss['time'] < time())) {
                            $bossStatus = ARMY_GENERAL_BOSS_STATUS_LOSE;
                        }
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $boss['id']; ?></td>
                    <td><?php echo Yii::t('Monster', $boss['monsterBasic']->monsterName); ?></td>
                    <td><?php echo $boss['LV']; ?></td>
                    <td><?php echo $bossStatusStr[$bossStatus]; ?></td>
                </tr>
                <?php 
                    }
                ?>
            </table>
            <table width = "720px">
                <tr>
                    <th colspan = "4" style = "border-top:none;"><?php echo Yii::t('AdminModule.Conquest', 'monster information'); ?></th>
                </tr>
                <tr>
                    <th width = "20%"><?php echo Yii::t('AdminModule.Conquest', 'serial number'); ?></th>
                    <th width = "20%"><?php echo Yii::t('AdminModule.Conquest', 'monster ID'); ?></th>
                    <th width = "40%"><?php echo Yii::t('AdminModule.Conquest', 'monster name'); ?></th>
                    <th width = "20%"><?php echo Yii::t('AdminModule.Conquest', 'monster level'); ?></th>
                </tr>
                <?php 
                    foreach ($monsterList as $index => $monster) {
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $monster['id']; ?></td>
                    <td><?php echo Yii::t('Monster', $monster['monsterBasic']->monsterName); ?></td>
                    <td><?php echo $monster['LV']; ?></td>
                </tr>
                <?php 
                    }
                ?>
            </table>
            <table width = "720px">
            <tr>
                <th style = "border:none; text-align:right;"><input type="button" style="width:30%;" value="<?php echo Yii::t('AdminModule.Conquest', 'retreat'); ?>(<?php echo Yii::t('Army', $army->armyName); ?>)" id='<?php echo $army->armyId; ?>' armyName = "<?php echo Yii::t('Army', $army->armyName); ?>" name="armyRetreat" ></th>
            </tr>
            </table>
        </div>
        <br><br>
        <?php 
            }
        ?>
    </div>
</div>

<script type="text/javascript">
    $("input[name='armyRetreat']").click (
        function (event) {
            var armyName = $(this).attr('armyName');
            $confirmMessage = "<?php echo Yii::t('AdminModule.Conquest', 'determinate to do'); ?>("+armyName+")<?php echo Yii::t('AdminModule.Conquest', 'retrest?'); ?>";
            $isRetreat = confirm($confirmMessage);
            if ($isRetreat) {
                var id = $(this).attr('id');
                var url = "<?php echo $this->createUrl('armyRetreat');?>";
                var data = "armyId="+id;
                ajaxloadJson(url, data, Replace);
            }
        }
    );
    $("input[name='changeFightingBar']").click (
        function (event) {
            var once = <?php echo $town->fightingBarMax/10; ?>;
            var operation = $(this).attr('value');
            if (operation == '+') {
                operation = 'add';
            }
            else {
                operation = 'reduce';
            }
            var id = <?php echo $town->townId; ?>;
            var url = "<?php echo $this->createUrl('changeFightingBar');?>";
            var data = "townId="+id+"&operation="+operation+"&once="+once;
            ajaxloadJson(url, data, Replace);
        }
    );
    $("input[name='refreshDanger']").click (
        function (event) {
            var id = <?php echo $town->townId; ?>;
            var url = "<?php echo $this->createUrl('refreshDanger');?>";
            var data = "townId="+id;
            ajaxloadJson(url, data, Replace);
        }
    );
    $("input[name='changeImportance']").click (
        function (event) {
            var id = <?php echo $town->townId; ?>;
            var r = /^\d+$/;
            var num = prompt("<?php echo Yii::t('AdminModule.Conquest', 'change number'); ?>", "(<?php echo Yii::t('AdminModule.Conquest', 'in fact its 1-10, for test can use 1-100 integer'); ?>)");
            if (num === null) {
                //do nothing
            }
            else if (r.test(num) && num >= 1 && num <= 100) {
                var url = "<?php echo $this->createUrl('changeImportance');?>";
                var data = "townId="+id+"&num="+num;
                ajaxloadJson(url, data, Replace);
            }
            else {
                alert("<?php echo Yii::t('AdminModule.Conquest', 'have said 1-100 integer'); ?>");
            }
        }
    );
    function Replace(result){
        location.replace(location.href);
    }
    
</script>