<div>
    <?php $townStatusStrList = Util::loadconfig('townStatus'); ?>
    </br>
    <div style="background-color:#FFFF99;">
        <span class="titleMenu red"><?php echo Yii::t('AdminModule.View', 'town info detail'); ?>【<?php echo Yii::t('Town', $town->townName); ?>】</span>
        <table width = "720px">
            <tr>
                <th width = "10%" height = "25px"><?php echo Yii::t('AdminModule.View', 'town id'); ?></th><td width = "15%"><?php echo $town->townId; ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.View', 'town name'); ?></th><td width = "15%"><?php echo Yii::t('Town', $town->townName); ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.View', 'area id'); ?></th><td width = "15%"><?php echo $town->areaId; ?></td>
                <th width = "10%"><?php echo Yii::t('AdminModule.View', 'area name'); ?></th><td width = "15%"><?php echo Yii::t('Area', $area->areaName); ?></td>
            </tr>
            <tr>
                <th height = "25px"><?php echo Yii::t('AdminModule.View', 'importance'); ?></th><td><?php echo $town->importance; ?> <input type="button" class="btnAdmin1" value="<?php echo Yii::t('AdminModule.View', 'change'); ?>" onClick="CMAction.changeImportance()"></td>
                <th><?php echo Yii::t('AdminModule.View', 'danger'); ?>MAX</th><td><?php echo $town->dangerMax; ?><input type="button" class="btnAdmin1" value="<?php echo Yii::t('AdminModule.View', 'change'); ?>" onClick="CMAction.changeDangerMax()"></td>
                <th><?php echo Yii::t('AdminModule.View', 'danger'); ?></th><td><?php echo $town->danger; ?></td>
                <td colspan="2"><input type="button" class="btnAdmin1" value="<?php echo Yii::t('AdminModule.View', 'refresh danger'); ?>" onClick="CMAction.refreshDanger()"></td>
            </tr>
            <tr>
                <th height = "25px"><?php echo Yii::t('AdminModule.View', 'status'); ?></th><td><?php echo $townStatusStrList['DB_STATUS_SHOW_PERFECT'][$town->status]; ?></td>
                <th><?php echo Yii::t('AdminModule.View', 'fightingBar'); ?>MAX</th><td><?php echo $town->fightingBarMax; ?><input type="button" class="btnAdmin1" value="<?php echo Yii::t('AdminModule.View', 'change'); ?>" onClick="CMAction.changeFightingBarMax()"></td>
                <th><?php echo Yii::t('AdminModule.View', 'fightingBar'); ?></th><td><input type="button" class="btnAdmin1" value="-" onClick="CMAction.changeFightingBar('reduce')"><?php echo $town->fightingBar; ?><input type="button" class="btnAdmin1" value = "+" onClick="CMAction.changeFightingBar('add')"></td>
                <td colspan="2"><input type="button" class="btnAdmin1" value="<?php echo Yii::t('AdminModule.View', 'refresh fightingBar'); ?>" onClick="CMAction.refreshFightingBar()"></td>
            </tr>
        </table>
    </div>
    <br>
    <div style="background-color:#FFCCCC;">
        <span class="titleMenu red"><?php echo Yii::t('AdminModule.View', 'army info detail'); ?></span>
        <?php 
            foreach ($armyList as $armyDetail) {
                $army = $armyDetail['army'];
                $bossList = $armyDetail['generalBoss'];
                $monsterList = $armyDetail['monster'];
        ?>
        <div>
            <table width = "720px">
                <tr>
                    <th colspan = "6"><?php echo Yii::t('AdminModule.View', 'basic param'); ?></th>
                </tr>
                <tr>
                    <th width = "15%"><?php echo Yii::t('AdminModule.View', 'army id'); ?></th><td width = "15%"><?php echo $army->armyId; ?></td>
                    <th width = "15%"><?php echo Yii::t('AdminModule.View', 'army name'); ?></th><td width = "25%"><?php echo Yii::t('Army', $army->armyName); ?></td>
                    <th width = "15%"><?php echo Yii::t('AdminModule.View', 'fightingBar'); ?></th><td width = "15%"><?php echo $army->fightingBar; ?></td>
                </tr>
            </table>
            <table width = "720px">
                <tr>
                    <th colspan = "5" style = "border-top:none;"><?php echo Yii::t('AdminModule.View', 'boss info detail'); ?></th>
                </tr>
                <tr>
                    <th width = "10%"><?php echo Yii::t('AdminModule.View', 'id'); ?></th>
                    <th width = "15%"><?php echo Yii::t('AdminModule.View', 'monster id'); ?></th>
                    <th width = "30%"><?php echo Yii::t('AdminModule.View', 'monster name'); ?></th>
                    <th width = "15%"><?php echo Yii::t('AdminModule.View', 'monster level'); ?></th>
                    <th width = "30%"><?php echo Yii::t('AdminModule.View', 'monster status'); ?></th>
                </tr>
                <?php 
                    foreach ($bossList as $index => $boss) {
                        $bossStatusStr = array(
                            ARMY_GENERAL_BOSS_STATUS_WAITING => Yii::t('AdminModule.View', 'boss status waiting'),
                            ARMY_GENERAL_BOSS_STATUS_FIGHTING => Yii::t('AdminModule.View', 'boss status fighting'),
                            ARMY_GENERAL_BOSS_STATUS_WIN => Yii::t('AdminModule.View', 'boss status win'),
                            ARMY_GENERAL_BOSS_STATUS_LOSE => Yii::t('AdminModule.View', 'boss status lose'),
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
                    <th colspan = "4" style = "border-top:none;"><?php echo Yii::t('AdminModule.View', 'monster info detail'); ?></th>
                </tr>
                <tr>
                    <th width = "20%"><?php echo Yii::t('AdminModule.View', 'id'); ?></th>
                    <th width = "20%"><?php echo Yii::t('AdminModule.View', 'monster id'); ?></th>
                    <th width = "40%"><?php echo Yii::t('AdminModule.View', 'monster name'); ?></th>
                    <th width = "20%"><?php echo Yii::t('AdminModule.View', 'monster level'); ?></th>
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
                <th style = "border:none; text-align:right;"><input type="button" style="width:30%;" value="<?php echo Yii::t('AdminModule.View', 'retreat'); ?>【<?php echo Yii::t('Army', $army->armyName); ?>】" id='<?php echo 'armyRetreat'.$army->armyId; ?>' armyName="<?php echo Yii::t('Army', $army->armyName); ?>" onClick="CMAction.armyRetreat(<?php echo $army->armyId; ?>)" ></th>
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
    window.CMAction = {
        operationConfirmInitData:function() {
            return confirm("<?php echo Yii::t('AdminModule.View', 'conquest manager operation confirm initData'); ?>");
        },
        replacePage:function(result) {
            location.replace(location.href);
        },
        armyRetreat:function(armyId) {
            var armyName = $('#armyRetreat'+armyId).attr('armyName');
            var isRetreat = confirm("【" + armyName + "】<?php echo Yii::t('AdminModule.View', 'army retreat confirm'); ?>");
            if (isRetreat) {
                var url = "<?php echo $this->createUrl('armyRetreat');?>";
                url += "&armyId="+armyId;
                SevenLoader.get(url, "CMAction.replacePage");
            }
        },
        changeImportance:function() {
            if (CMAction.operationConfirmInitData()) {
                var r = /^\d+$/;
                var num = prompt("<?php echo Yii::t('AdminModule.View', 'change importance input'); ?>", "<?php echo Yii::t('AdminModule.View', 'change importance check alert'); ?>");
                if (num === null) {
                    //do nothing
                }
                else if (r.test(num) && num >= 1 && num <= 100) {
                    var url = "<?php echo $this->createUrl('changeImportance');?>";
                    url += "&townId="+<?php echo $town->townId; ?>+"&num="+num;
                    SevenLoader.get(url, "CMAction.replacePage");
                }
                else {
                    alert("<?php echo Yii::t('AdminModule.View', 'change importance check alert'); ?>");
                }
            }
        },
        changeDangerMax:function() {
            if (CMAction.operationConfirmInitData()) {
                var r = /^\d+$/;
                var num = prompt("<?php echo Yii::t('AdminModule.View', 'change danger max input'); ?>", "<?php echo Yii::t('AdminModule.View', 'change danger max check alert'); ?>");
                if (num === null) {
                    //do nothing
                }
                else if (r.test(num) && num >= 1) {
                    var url = "<?php echo $this->createUrl('changeDangerMax');?>";
                    url += "&townId="+<?php echo $town->townId; ?>+"&num="+num;
                    SevenLoader.get(url, "CMAction.replacePage");
                }
                else {
                    alert("<?php echo Yii::t('AdminModule.View', 'change danger max check alert'); ?>");
                }
            }
        },
        changeFightingBarMax:function() {
            if (CMAction.operationConfirmInitData()) {
                var r = /^\d+$/;
                var num = prompt("<?php echo Yii::t('AdminModule.View', 'change fightingBar max input'); ?>", "<?php echo Yii::t('AdminModule.View', 'change fightingBar max check alert'); ?>");
                if (num === null) {
                    //do nothing
                }
                else if (r.test(num) && num >= 1) {
                    var url = "<?php echo $this->createUrl('changeFightingBarMax');?>";
                    url += "&townId="+<?php echo $town->townId; ?>+"&num="+num;
                    SevenLoader.get(url, "CMAction.replacePage");
                }
                else {
                    alert("<?php echo Yii::t('AdminModule.View', 'change fightingBar max check alert'); ?>");
                }
            }
        },
        changeFightingBar:function(changeType) {
            var num;
            if (changeType == 'add') {
                num = prompt("<?php echo Yii::t('AdminModule.View', 'add fightingBar input'); ?>", "<?php echo Yii::t('AdminModule.View', 'change fightingBar check alert'); ?>");
            }
            else if (changeType == 'reduce') {
                num = prompt("<?php echo Yii::t('AdminModule.View', 'reduce fightingBar input'); ?>", "<?php echo Yii::t('AdminModule.View', 'change fightingBar check alert'); ?>");
            }
            
            var r = /^\d+$/;
            if (num === null) {
                //do nothing
            }
            else if (r.test(num) && num >= 1) {
                var url = "<?php echo $this->createUrl('changeFightingBar');?>";
                url += "&townId="+<?php echo $town->townId; ?>+"&num="+num+"&type="+changeType;
                SevenLoader.get(url, "CMAction.replacePage");
            }
            else {
                alert("<?php echo Yii::t('AdminModule.View', 'change fightingBar check alert'); ?>");
            }
        },
        refreshDanger:function() {
            var isRefresh = confirm("<?php echo Yii::t('AdminModule.View', 'refresh danger confirm'); ?>");
            if (isRefresh) {
                var url = "<?php echo $this->createUrl('refreshDanger');?>";
                url += "&townId="+<?php echo $town->townId; ?>;
                SevenLoader.get(url, "CMAction.replacePage");
            }
        },
        refreshFightingBar:function() {
            var isRefresh = confirm("<?php echo Yii::t('AdminModule.View', 'refresh fightingBar confirm'); ?>");
            if (isRefresh) {
                var url = "<?php echo $this->createUrl('refreshFightingBar');?>";
                url += "&townId="+<?php echo $town->townId; ?>;
                SevenLoader.get(url, "CMAction.replacePage");
            }
        },
    }
</script>