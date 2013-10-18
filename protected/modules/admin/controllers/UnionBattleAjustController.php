<?php
class UnionBattleAjustController extends Controller{	
	
	public function actionUpdateRankBaseId(){
		$period = 14;
		$unionsLevel = $this->getUnionsLevel($period);
		
		foreach ($unionsLevel as $val){
			$union = Union::factory($val['unionId']);
			$unionLvBase = $this->getUnionLvBase($val['unionLevel']);
			$rankBaseId = ceil((($unionLvBase['minRankBaseId']+$unionLvBase['maxRankBaseId'])/2)-1);
			$rankBaseId = $rankBaseId < $unionLvBase['minRankBaseId'] ?$unionLvBase['minRankBaseId']:($rankBaseId > $unionLvBase['maxRankBaseId']?$unionLvBase['maxRankBaseId']:$rankBaseId);
			$union->rankBaseId = $rankBaseId;
			$union->saveAttributes(array('rankBaseId'));
		}
		
	}
 	private function getUnionLvBase($level){
 		$command = Yii::app()->db->createCommand("select * from unionLvBase where minLevel<=:level and maxLevel>=:level");
 		$command->bindValue(':level',$level);
 		return $command->queryRow();
 	}	
	public function getUnionsLevel($period){
		$command = Yii::app()->db->createCommand('select unionId,unionLevel from `union` where period=:period');
 		$command->bindValue(':period',$period);
 		return $command->queryAll();
	}	
	
//	public function actionUpdateIsActive(){
//		$period = 13;
////		$unionPlayers = $this->getUnionPlayer($period);
////		foreach ($unionPlayers as $playerId){
////			if(PlayerLogin::isActivePlayer($playerId)){
////				$unionPlayer = UnionPlayer::getUnionPlayerByPlayerIdPeriod($playerId, $period);
////				$unionPlayer->isActive = 1;
////				$unionPlayer->saveAttributes(array('isActive'));
////			}else{
////				continue;
////			}
////		}
//		$unionIds = $this->getUnionIds($period);
//		foreach ($unionIds as $unionId){
//			$union = Union::factory($unionId);
//			$playerIds = $this->getPlayerIds($unionId);
//			$activeMemberNum = 0;
//			foreach ($playerIds as $playerId){
//				if(PlayerLogin::isActivePlayer($playerId)){
//					$unionPlayer = UnionPlayer::getUnionPlayerByPlayerIdPeriod($playerId, $period);
//					$unionPlayer->isActive = 1;
//					$activeMemberNum += 1;
//					$unionPlayer->saveAttributes(array('isActive'));
//					unset($unionPlayer);
//				}
//			}
//			if($activeMemberNum != $union->activeMemberNum){
//				$union->activeMemberNum = $activeMemberNum;
//				$union->saveAttributes(array('activeMemberNum'));
//			}
//		}
//	}
//	public function getUnionIds($period){
//		$command = Yii::app()->db->createCommand('select unionId from `union` where period=:period');
// 		$command->bindValue(':period',$period);
// 		return $command->queryColumn();
//	}
//	public function getPlayerIds($unionId){
//		$command = Yii::app()->db->createCommand('select playerId from unionPlayer where unionId=:unionId');
// 		$command->bindValue(':unionId',$unionId);
// 		return $command->queryColumn();
//	}
//	public function actionAddUItem(){ //因怪物生成有误，赠送玩家气力药水*2,行动力药水*2
//		$unionPlayerIds = $this->getUnionPlayerIdByUnionId();
//		if(!$unionPlayerIds){
//			return false;
//		}
//		$uItemIds = array(6,6,2,2);
//		foreach ($unionPlayerIds as $playerId){
//			$transaction = Yii::app()->db->beginTransaction();
//			try {
//				$equipmentBag = new TemporaryBag($playerId);
//				$equipmentBag->addItems($uItemIds,ITEM_TYPE_UITEM,4);
//				$transaction->commit();
//			}catch(Exception $e){
//	            $transaction->rollback();
//	            throw $e;
//        	}
//		}
//		$url = $this->createUrl('default/index');
//		$this->redirect($url);
//	}
//	public function getUnionPlayerIdByUnionId(){
////		$unionIds = '1533,1538,1542,1549,1554,1561,1569,1579,1586,1595';
//		$unionIds = '1533,1538,1542,1549,1554,1561,1569,1579,1586,1595';
//		$command = Yii::app()->db->createCommand("select playerId from `unionPlayer` where unionId in (".$unionIds.")");
// 		return $command->queryColumn();
//	}
//	
//	public function actionAddEnergyItem(){ //因贡献度计算有误，赠送玩家气力药水*2
//		$unionPlayerIds = $this->getUnionPlayerIds();
//		if(!$unionPlayerIds){
//			return false;
//		}
//		$uItemIds = array(6,6);
//		foreach ($unionPlayerIds as $playerId){
//			$transaction = Yii::app()->db->beginTransaction();
//			try {
//				$equipmentBag = new TemporaryBag($playerId);
//				$equipmentBag->addItems($uItemIds,ITEM_TYPE_UITEM,4);
//				$transaction->commit();
//			}catch(Exception $e){
//	            $transaction->rollback();
//	            throw $e;
//        	}
//		}
//		$url = $this->createUrl('default/index');
//		$this->redirect($url);
//	}
//	public function getUnionPlayerIds(){
// 		$command = Yii::app()->db->createCommand("select playerId from `unionPlayer` where ranking>0 and period = 8");
// 		return $command->queryColumn();
//	}
	
//	
//	/**
//	 * 设置活跃用户
//	 * Enter description here ...
//	 */
//    public function actionPlayerLogin(){
//    	$playerIds = $this->getAllPlayerIds();
//    	foreach ($playerIds as $playerId){
//    		if($this->getPlayerLogin($playerId)){
//    			$playerLogin = new PlayerLogin($playerId);
//    			$playerLogin->saveAttributes(array('lastLoginTime'=>time()));
//    		}else{
//    			PlayerLogin::create(array('playerId'=>$playerId,'lastLoginTime'=>time()));
//    		}
//    	}
//    }
//    public function getAllPlayerIds(){
//    	$command = Yii::app()->db->createCommand('select playerId from player');
//    	return $command->queryColumn();
//    }
//    public function getPlayerLogin($playerId){
//    	$command = Yii::app()->db->createCommand('select playerId from playerLogin where playerId=:playerId');
//    	return $command->bindValue(':playerId',$playerId)->queryRow();
//    }	
//	/**
//	 * 同盟军等级调整
//	 * Enter description here ...
//	 */
//	public function actionIndex(){
//		$db = Yii::app()->db;
//		$period = Util::getUnionPeriod();
//		$unions = $this->getUnionsByPeriod($period);
//		
//		$transaction = $db->beginTransaction();
//		try{
//			$time = time();
//			$timeList = Util::loadconfig("unionBattleTime");
//			foreach($unions as $unionInfo){
//				$union = Union::factory($unionInfo['unionId']);
//				
//				$currentKey = $union->currentBattleKey;
//				$currentBattleStartTime = strtotime(date('Y-m-d',time()).' '
//				.intval($currentKey).':'
//				.($currentKey*3600%3600/60)
//				.':'.($currentKey*3600%3600%60));
//				
//				$battle = $this->getBattle($union->unionId);
//				
//				$avgLevel = $this->getAvgLevel($union->unionId);
//				$union->unionLevel = $avgLevel;
//				$union->currentBattleStartTime = $battle->startTime;
//
//				$union->saveAttributes(array('currentBattleStartTime','unionLevel'));
//				unset($union,$battle);
//			}
//			$transaction->commit();
//		}catch(Exception $e){
//            $transaction->rollback();
//            throw $e;
//        }
//	}
// 	private function getMonsterBasic($basicId){
// 		$command = Yii::app()->db->createCommand("select * from monsterBasic where monsterBasicId=:basicId");
// 		$command->bindValue(':basicId',$basicId);
// 		return $command->queryRow();
// 	}
// 	private function getRankBase($rankId){
// 		$command = Yii::app()->db->createCommand("select * from rankBase where rankId=:rankId");
// 		$command->bindValue(':rankId',$rankId);
// 		return $command->queryRow();
// 	}
//    public function getMonsterInfo($monsterBasic,$monsterLevel,$default=array()) {//monsterLevel=>level or rankId
//        $rankBase = $this->getRankBase($monsterLevel); 
//        $monsterInfo = array(
//            'monsterBasicId' => $monsterBasic['monsterBasicId'],
//            'monsterName' => $monsterBasic['monsterName'],
//            'monsterLevel' => $rankBase['monsterLevel'],
//            'attribute' => $monsterBasic['attribute'],
//        									//param=baseParam%*(RankBaseLv对应的Param)
//            'hp' => isset($default['hp'])?$default['hp']:ceil(($monsterBasic['hp']/100)*$rankBase['hp']),
//            'hpMax' => isset($default['hpMax'])?$default['hpMax']:ceil(($monsterBasic['hp']/100)*$rankBase['hp']),
//        	'attack' => isset($default['attack'])?$default['attack']:ceil(($monsterBasic['attack']/100)*$rankBase['attack']),
//            'speed' => isset($default['speed'])?$default['speed']:ceil(($monsterBasic['speed']/100)*$rankBase['speed']),
//            'restore' => isset($default['restore'])?$default['restore']:ceil(($monsterBasic['restore']/100)*$rankBase['restore']),
//            'hitNum' => $monsterBasic['hitNum'],
//            'think' => $monsterBasic['think'],
//            'monsterAI' => $monsterBasic['monsterAI'],
//            'turn1' => $monsterBasic['turn1'],
//            'turn2' => $monsterBasic['turn2'],
//            'turn3' => $monsterBasic['turn3'],
//            'turn4' => $monsterBasic['turn4'],
//            'turn5' => $monsterBasic['turn5'],
//            'turn6' => $monsterBasic['turn6'],
//            'turn7' => $monsterBasic['turn7'],
//            'cri' => $monsterBasic['cri'],
//        	'rank'=>$monsterLevel,
//        );
//        return $monsterInfo;
//    }
//	public function getBattle($unionId){
//		$db = Yii::app()->db;
//		$command = $db->createCommand("select * from battle where type = 1 and sponsorId = :unionId order by createTime desc limit 1");
//		$command->bindValue(':unionId', $unionId);
//		$record = $command->queryRow();
//		
//		return Battle::factory($record['battleId']);
//	}
//	public function getAvgLevel($unionId){
//		$playerIds = $this->getUnionPlayerIds($unionId);
//		$sumLevel = 0;
//		foreach($playerIds as $playerId){
//			$sumLevel += $this->getMaxLevel($playerId);
//		}
//		return ceil($sumLevel/count($playerIds));
//	}
//	public function getUnionPlayerIds($unionId){
//		$db = Yii::app()->db;
//		$command = $db->createCommand("select playerId from unionPlayer where unionId = :unionId");
//		return $command->bindValue(':unionId', $unionId)->queryColumn();
//	}
//	public function getMaxLevel($playerId){
//		$db = Yii::app()->db;
//		$command = $db->createCommand("select MAX(level) as level from playerCharacter where 
//		playerId = :playerId and deleteFlag = 0 and origin >=1
//		");
//		return $command->bindValue(':playerId', $playerId)->queryScalar();
//	}
// 	public function getArmy($armyId){
// 		 $command = Yii::app()->db->createCommand('select * from unionArmy where unionArmyId=:unionArmyId');
// 		 $command->bindValue(':unionArmyId',$armyId);
// 		 return $command->queryRow();
// 	}
// 	private function getMonsterLevel($period){
// 		$command = Yii::app()->db->createCommand('select * from unionLv where period=:period');
// 		$command->bindValue(':period',$period);
// 		return $command->queryRow();
// 	} 
// 	private function getUnionLvBase($level){
// 		$command = Yii::app()->db->createCommand("select * from unionLvBase where minLevel<=:level and maxLevel>=:level");
// 		$command->bindValue(':level',$level);
// 		return $command->queryRow();
// 	}
// 	private function getUnionsByPeriod($period){
// 		$command = yii::app()->db->createCommand('select unionId,isEnd from `union` where period=:period');
// 		$command->bindValue(':period',$period);
// 		return $command->queryAll();
// 	}
}

?>