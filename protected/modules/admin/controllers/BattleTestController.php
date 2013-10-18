<?php

class BattleTestController extends Controller
{
	public function filters(){
        return array(
            'CheckTestMode',
        );
    }

	public function filterCheckTestMode($filterChain){
        if(!Yii::app()->params['test']){
			echo "This function can only use in test mode";
            Yii::app()->end();
        }
        $filterChain->run();
        return true;

	}	

	public function actionIndex()
	{
		$result = '';
		$playerId = 1;
		$monsterBasicId = 1;
		$monsterLevel = 1;
		if(isset($_POST['showResult']) or isset($_POST['enterBattle'])){
			$playerId = $_POST['playerId'];
			$monsterBasicId = $_POST['monsterBasicId'];
			$monsterLevel = $_POST['monsterLevel'];
			
			$player = Player::factory($playerId);
			$battleManager = new BattleManager;
			$monsterBasic = MonsterBasic::factory($monsterBasicId);
			$monster = $monsterBasic->makeNewMonster($monsterLevel);
			$battle = $battleManager->createBattleWithMonster($player, $monster, 1);
			$battleManager->enterBattle($battle, $player);
			if(isset($_POST['showResult'])){
				$battlePartner = $battleManager->getBattlePartner($battle, $player);
				$provider = $battleManager->getBattleDataProvider($battle, $battlePartner);
				$battleProcess = $provider->autoRun();
				if($battle->isWin()){
					$result = 'win';
				}
				else{
					$result = 'lose';
				}
			}
			else{
				$this->redirect(Yii::app()->createAbsoluteUrl('battle/index', array('battleId'=>$battle->battleId)));
			}
		}

		$this->render('index', array('result' => $result, 'playerId' => $playerId, 'monsterBasicId' => $monsterBasicId, 'monsterLevel' => $monsterLevel));
	}
}