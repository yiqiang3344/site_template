<div>
    <br>
    <span style='font-size:20px;font-weight: bold;'><?php echo Yii::t('AdminModule.TestPlayer', 'test account list'); ?></span>
    <br><br>
    <table>
    <tr>
        <th style="width:100px;height:25px;"><?php echo Yii::t('AdminModule.TestPlayer', 'player ID'); ?></th>
        <th style="width:200px;"><?php echo Yii::t('AdminModule.TestPlayer', 'player name'); ?></th>
        <th style="width:150px;"><?php echo Yii::t('AdminModule.TestPlayer', 'status'); ?></th>
        <th style="width:150px;"><?php echo Yii::t('AdminModule.TestPlayer', 'operate'); ?></th>
    </tr>
    <?php 
        foreach ($dataList as $data) {
            $testPlayer = $data['testPlayer'];
            $player = $data['player'];
    ?>
        <tr>
            <td><?php echo $testPlayer->playerId; ?></td>
            <?php 
                if (isset($player)) {
            ?>
                <td><?php echo $player->playerName; ?></td>
                <?php 
                    if ($testPlayer->testFlag == 1) {
                ?>
                    <td><?php echo Yii::t('AdminModule.TestPlayer', 'test account'); ?></td>
                    <td><input playerId = "<?php echo $testPlayer->playerId; ?>" type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'change to general account'); ?>" testFlag="0" name="changeTestFlag">  <input playerId = "<?php echo $testPlayer->playerId; ?>" type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'delete'); ?>" name="deleteTestPlayer"></td>
                <?php 
                    }
                    else {
                ?>
                    <td><?php echo Yii::t('AdminModule.TestPlayer', 'general account'); ?></td>
                    <td><input playerId = "<?php echo $testPlayer->playerId; ?>" type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'change to test account'); ?>" testFlag="1" name="changeTestFlag">  <input playerId = "<?php echo $testPlayer->playerId; ?>" type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'delete'); ?>" name="deleteTestPlayer"></td>
                <?php 
                    }
                ?>
            <?php 
                }
                else {
            ?>
                <td></td>
                <td><?php echo Yii::t('AdminModule.TestPlayer', 'player not exist'); ?></td>
                <td><input playerId = "<?php echo $testPlayer->playerId; ?>" type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'delete'); ?>" name="deleteTestPlayer"></td>
            <?php 
                }
            ?>
        </tr>
    <?php } ?>
    </table>
    <br><br><br><br>
    <span style='font-size:20px;font-weight: bold;'><?php echo Yii::t('AdminModule.TestPlayer', 'add test account'); ?></span>
    <br><br>
    <table>
        <tr>
            <td style="width:50px;border-width:0px;"><?php echo Yii::t('AdminModule.TestPlayer', 'player ID'); ?></td>
            <td style="width:100px;border-width:0px;"><input id="addTestPlayerText"style="width:100px" type="text-area" value=""></td>
            <td style="width:50px;border-width:0px;"><input type="button" class="btn" value="<?php echo Yii::t('AdminModule.TestPlayer', 'add'); ?>" name="addTestPlayer"></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    $("input[name='changeTestFlag']").click (
        function (event) {
            var playerId = $(this).attr('playerId');
            var value = $(this).attr('value');
            confirmMessage = "<?php echo Yii::t('AdminModule.TestPlayer', 'confirm'); ?>"+playerId+"<?php echo Yii::t('AdminModule.TestPlayer', 'player to do'); ?>"+value+"<?php echo Yii::t('AdminModule.TestPlayer', 'operate?'); ?>";
            isDo = confirm(confirmMessage);
            if (isDo) {
                var newTestFlag = $(this).attr('testFlag');
                var url = "<?php echo $this->createUrl('changeTestFlag');?>";
                var data = "playerId="+playerId+"&testFlag="+newTestFlag;
                ajaxloadJson(url, data, Replace);
            }
        }
    );
    $("input[name='deleteTestPlayer']").click (
        function (event) {
            var playerId = $(this).attr('playerId');
            confirmMessage = "<?php echo Yii::t('AdminModule.TestPlayer', 'confirm to delete from testPlayer'); ?>"+playerId+"<?php echo Yii::t('AdminModule.TestPlayer', 'playernumber?'); ?>";
            isDo = confirm(confirmMessage);
            if (isDo) {
                var url = "<?php echo $this->createUrl('deleteTestPlayer');?>";
                var data = "playerId="+playerId;
                ajaxloadJson(url, data, Replace);
            }
        }
    );
    $("input[name='addTestPlayer']").click (
        function (event) {
            var playerId = document.getElementById('addTestPlayerText').value
            confirmMessage = "<?php echo Yii::t('AdminModule.TestPlayer', 'confirm to'); ?>"+playerId+"<?php echo Yii::t('AdminModule.TestPlayer', 'add player to TestPlayer'); ?>";
            isDo = confirm(confirmMessage);
            if (isDo) {
                var url = "<?php echo $this->createUrl('addTestPlayer');?>";
                var data = "playerId="+playerId;
                ajaxloadJson(url, data, AddTestPlayerResult);
            }
        }
    );
    
    AddTestPlayerResult = function(result) {
        if (result.resultFlag == 1) {
        }
        else if (result.resultFlag == 2) {
            alert(<?php echo Yii::t('AdminModule.TestPlayer', 'player not exist'); ?>);
        }
        else if (result.resultFlag == 3) {
            alert(<?php echo Yii::t('AdminModule.TestPlayer', 'already be test account'); ?>);
        }
        else {
            alert(<?php echo Yii::t('AdminModule.TestPlayer', 'wrong player ID'); ?>);
        }
        Replace();
    }
    Replace = function(){
        location.replace(location.href);
    }
</script>