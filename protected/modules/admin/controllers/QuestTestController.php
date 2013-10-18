<?php
class QuestTestController extends Controller
{
	
	public function actionIndex(){
		$this->render('index');
	}
	function actionUnlockAllQuest(){
		$playerId = $_POST['playerId'];
		if(!$playerId){
			return;
		}
		$player = Player::factory($playerId);
		if(!$player){
			return ;
		}
        $command = Yii::app()->db->createCommand();
        $command->select('questId')->from('quest');
        $questIds = $command->queryColumn();
        
        $command->update('questRank', array('rank'=>QUEST_RANK), 'playerId = :playerId', array(':playerId'=>$playerId));
        
        foreach ($questIds as $questId){
        	QuestPlayer::create($playerId, $questId);
        	$command->insert('questRecord', array('playerId'=>$playerId,
        	'questId'=>$questId,
        	'questCategory'=>0,
        	'taskId'=>0,
        	'status'=>2,
        	'acceptTime'=>0,
        	'completeTime'=>0));
        }
        $url = $this->createUrl('questTest/index');
        $this->redirect($url);
	}
	public function actionUnlockARank(){
		$playerId = $_POST['playerId'];
		if(!$playerId){
			return ;
		}
		$player = Player::factory($playerId);
		if(!$player){
			return ;
		}
		$rankId = $_POST['rankId'];
		$questRank = QuestRank::getRankByPlayerId($playerId);
		
		if($rankId<$questRank['rank']){
			return ;
		}
		$questIds = Quest::getAllQuestByRank($rankId);
		array_pop($questIds);
		$command = Yii::app()->db->createCommand();
        foreach ($questIds as $questId){
        	QuestPlayer::create($playerId, $questId);
        	$command->insert('questRecord', array('playerId'=>$playerId,
        	'questId'=>$questId,
        	'questCategory'=>0,
        	'taskId'=>0,
        	'status'=>2,
        	'acceptTime'=>0,
        	'completeTime'=>0));
        }
        $url = $this->createUrl('questTest/index');
        $this->redirect($url);
		//foreach ($questIds)
	}
	
	
	
	
	
}