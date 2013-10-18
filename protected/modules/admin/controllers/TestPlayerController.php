<?php

class TestPlayerController extends Controller{
    public $layout = 'testPlayer';
    
    public function actionTestPlayerList() {
        $testPlayerList = TestPlayer::getAllTestPlayer();
        $dataList = array();
        foreach ($testPlayerList as $testPlayer) {
            $player = Yii::app()->objectLoader->load('Player', $testPlayer->playerId);
            if ($player->isNew()) {
                $player = null;
            }
            $dataList[] = array('testPlayer' => $testPlayer, 'player' => $player);
        }
        $this->render('testPlayerList', array('dataList' => $dataList));
    }
    
    public function actionChangeTestFlag() {
        $this->isAjax = true;
        $playerId = $_GET['playerId'];
        $newTestFlag = $_GET['testFlag'];
        $testPlayer = Yii::app()->objectLoader->load('TestPlayer', $playerId);
        $testPlayer->changeTestFlag($newTestFlag);
        $this->display('');
    }
    
    public function actionDeleteTestPlayer() {
        $this->isAjax = true;
        $playerId = $_GET['playerId'];
        $testPlayer = Yii::app()->objectLoader->load('TestPlayer', $playerId);
        $testPlayer->deleteSelf();
        $this->display('');
    }
    
    public function actionAddTestPlayer() {
        $this->isAjax = true;
        $playerId = $_GET['playerId'];
        $data = array('resultFlag' => 0);
        if (preg_match("/^\d+$/", $playerId)) {
            $player = Yii::app()->objectLoader->load('Player', $playerId);
            $testPlayer = Yii::app()->objectLoader->load('TestPlayer', $playerId);
            if ($player->isNew()) {
                $data['resultFlag'] = 2;
            }
            else if (!$testPlayer->isNew()) {
                $data['resultFlag'] = 3;
            }
            else {
                TestPlayer::addNewTestPlayer($playerId);
                $data['resultFlag'] = 1;
            }
        }
        $this->display('', $data);
    }
}

?>
