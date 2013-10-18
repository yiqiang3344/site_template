<style>
    table {border-width:1px; border-color:black; border-collapse:collapse; margin:auto;margin-top:10px;}
    th,td {border-width:1px; border-style:inset; border-color:black; valign="middle";}
    .t_title{background:#cccccc;}
    h3 {font-size:24px;width:900px;text-align:center;}
</style>
<h3>Area Distribution Report</h3>
<table>
    <tr class='t_title'>
        <td style='text-align:center'></td>
        <td style='text-align:center' colspan=6></td>
        <td style='text-align:center' colspan=3 width=10px>人均剩余行动力药水</td>
        <td style='text-align:center' colspan=3 width=10px>人均剩余气力药水</td>
        <td style='text-align:center' colspan=4>人均稀有职业个数</td>
    </tr>
    <tr class='t_title'>
        <td style='text-align:center;width:40px;'>area</td>
        <td style='text-align:center;width:80px;'>总人数</td>
        <td style='text-align:center;width:80px;'>人均Gold</td>
        <td style='text-align:center;width:120px;'>人均ReputationLevel </td>
        <td style='text-align:center;width:120px;'>角色的最高等级</td>
        <td style='text-align:center;width:120px;'>当前最高的紧急怪的clear次数</td>
        <td style='text-align:center;width:80px;'>人均总贡献度</td>
        <td style='text-align:center;width:60px;'>小</td>
        <td style='text-align:center;width:60px;'>中</td>
        <td style='text-align:center;width:60px;'>大</td>
        <td style='text-align:center;width:60px;'>小</td>
        <td style='text-align:center;width:60px;'>中</td>
        <td style='text-align:center;width:60px;'>大</td>
        <td style='text-align:center;width:120px;'>铜</td>
        <td style='text-align:center;width:120px;'>银</td>
        <td style='text-align:center;width:120px;'>金</td>
        <td style='text-align:center;width:120px;'>红</td>
    </tr>
    <?php foreach($data as $rank=>$info) {?>
    <tr style='text-align:center;'>
        <td style='text-align:center;'>area<?php echo $rank;?></td>
        <td style='text-align:center;'><?php echo number_format($info['playerNum']);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averGold'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averLv'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['charMaxLv']);?></td>
        <td style='text-align:center;'><?php echo number_format($info['maxClearTimes']);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averContribution'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averSmallAP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averMiddleAP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averBigAP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averSmallEP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averMiddleEP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averBigEP'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averCommonChar'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averSilverChar'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averGoldChar'], 2);?></td>
        <td style='text-align:center;'><?php echo number_format($info['averRedChar'], 2);?></td>
    </tr>
    <?php }?>
</table>
