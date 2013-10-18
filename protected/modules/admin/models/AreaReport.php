<?php
class AreaReport extends CFormModel {
    public function getAreaDistribute(){
        $sql = 'select q.rank, count(*) as playerNum, sum(p.`gold`)/count(*) as averGold, sum(p.`reputationLevel`)/count(*) as averLv from player p, questRank q where p.playerid=q.playerid and  p.tutorialProcess=1 and p.deleteflag=0 group by q.rank';
        $area = Yii::app()->db->createCommand($sql)->queryAll();
        $area = Util::changeArrayToHashByKey($area, 'rank');
        return $area;
    }

    public function getCharacterMaxLv(){
        $sql = 'select q.rank, max(pc.`level`) as charMaxLv from player p, questRank q, playerCharacter pc where p.playerid=q.playerid and p.playerid=pc.playerid and  p.tutorialProcess=1 and p.deleteflag=0 and pc.deleteflag=0 group by rank';
        $maxLv = Yii::app()->db->createCommand($sql)->queryAll();
        $maxLv = Util::changeArrayToHashByKey($maxLv, 'rank');
        return $maxLv;
    }

    public function getItemNum(){
        $sql = 'select q.`rank`,pI.objectId, count(*) as itemNum from player p, questRank q, playerItem pI where p.playerid=q.playerid and p.playerid=pI.playerid and  p.tutorialProcess=1 and p.deleteflag=0 and pI.deleteflag=0 and pI.itemtype=1 group by q.rank, pI.objectid';
        $item = Yii::app()->db->createCommand($sql)->queryAll();
        $itemNum = array();
        foreach($item as $info){
            $rank = $info['rank'];
            $objectId = $info['objectId'];
            $itemNum[$rank][$objectId] = $info['itemNum'];
        }
        return $itemNum;
    }

    public function getGuildContribution(){
        $sql = 'select q.`rank`, sum(g.`contributions`) as contribution from player p, questRank q, guildPlayer g where p.playerid=q.playerid and p.playerid=g.playerid and  p.tutorialProcess=1 and p.deleteflag=0 group by q.rank';
        $contribution = Yii::app()->db->createCommand($sql)->queryAll();
        $contribution = Util::changeArrayToHashByKey($contribution, 'rank');
        return $contribution;
    }

    public function getRemainCharacter(){
        $sql = 'select q.`rank`, pc.rare as rare, count(*) as charNum from player p, questRank q, playerCharacter pc, characterTemplate ct where p.playerid=q.playerid and p.playerid=pc.playerid and  p.tutorialProcess=1 and p.deleteflag=0 and pc.deleteflag=0 and pc.characterTemplateId = ct.characterTemplateId and ct.functionType not in (7,8) and pc.jobId in (11,12,15,16) group by rank, pc.rare';
        $character = Yii::app()->db->createCommand($sql)->queryAll();
        $characterNum = array();
        foreach($character as $info){
            $rank = $info['rank'];
            $rare = $info['rare'];
            $characterNum[$rank][$rare] = $info['charNum'];
        }
        return $characterNum;
    }

    public function getMaxUrgentMonsterClearTimes(){
        $sql = 'select rank, max(clearNum) as maxClearTimes from questRank qr,questPlayer qp, player p where qr.playerId=qp.playerId and qr.playerId=p.playerId and p.tutorialProcess=1 and qp.questId=229 group by qr.rank';
        $maxClearTimes = Yii::app()->db->createCommand($sql)->queryAll();
        $maxClearTimes = Util::changeArrayToHashByKey($maxClearTimes, 'rank');
        return $maxClearTimes;
    }

    public function getAreaInfo() {
        $area = $this->getAreaDistribute();
        $maxLv = $this->getCharacterMaxLv();
        $itemNum = $this->getItemNum();
        $contribution = $this->getGuildContribution();
        $remainCharNum = $this->getRemainCharacter();
        $maxClearTimes = $this->getMaxUrgentMonsterClearTimes();
        foreach($area as $rank=>$info){
            $info['charMaxLv'] = isset($maxLv[$rank]) ? $maxLv[$rank]['charMaxLv'] : 0;
            $info['averSmallAP'] = isset($itemNum[$rank]['1']) ? $itemNum[$rank]['1']/$info['playerNum'] : 0;
            $info['averMiddleAP'] = isset($itemNum[$rank]['2']) ? $itemNum[$rank]['2']/$info['playerNum'] : 0;
            $info['averBigAP'] = isset($itemNum[$rank]['3']) ? $itemNum[$rank]['3']/$info['playerNum'] : 0;
            $info['averSmallEP'] = isset($itemNum[$rank]['4']) ? $itemNum[$rank]['4']/$info['playerNum'] : 0;
            $info['averMiddleEP'] = isset($itemNum[$rank]['5']) ? $itemNum[$rank]['5']/$info['playerNum'] : 0;
            $info['averBigEP'] = isset($itemNum[$rank]['6']) ? $itemNum[$rank]['6']/$info['playerNum'] : 0;
            $info['averContribution'] = isset($contribution[$rank]['contribution']) ? $contribution[$rank]['contribution']/$info['playerNum'] : 0;
            $info['maxClearTimes'] = $maxClearTimes[$rank]['maxClearTimes'];
            $info['averCommonChar'] = isset($remainCharNum[$rank]['0']) ? $remainCharNum[$rank]['0']/$info['playerNum'] : 0;
            $info['averSilverChar'] = isset($remainCharNum[$rank]['1']) ? $remainCharNum[$rank]['1']/$info['playerNum'] : 0;
            $info['averGoldChar'] = isset($remainCharNum[$rank]['2']) ? $remainCharNum[$rank]['2']/$info['playerNum'] : 0;
            $info['averRedChar'] = isset($remainCharNum[$rank]['3']) ? $remainCharNum[$rank]['3']/$info['playerNum'] : 0;
            $area[$rank] = $info;
        }
        return $area;
    }
    
    public static function parseDayStr($dayStr) {
        if (preg_match("/^(\d*)\/(\d*)\/(\d*)$/", $dayStr, $matchs)) {
            return mktime(0,0,0,intval($matchs[2]),intval($matchs[3]),intval($matchs[1]));
        }
    }
}
?>
