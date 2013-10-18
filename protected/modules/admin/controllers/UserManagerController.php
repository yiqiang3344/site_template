<?php

class UserManagerController extends Controller{
    public $layout='/layouts/support';
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionPlayerDetail() {
        $searchType = $_GET['type'];
        $searchCondition = $_GET['data'];
        $dataList = array('hasPlayer'=>false, 'player' => null);
        if ($searchType == 'id') {
            $player = Yii::app()->objectLoader->load('Player', $searchCondition);
            if (!$player->isNew()) {
                $dataList['hasPlayer'] = true;
                $dataList['player'] = $player;
            }
        }
        else if ($searchType == 'name') {
            $player = Player::findByName($searchCondition);
            if (isset($player)) {
                $dataList['hasPlayer'] = true;
                $dataList['player'] = $player;
            }
        }
        if ($dataList['hasPlayer'] === true) {
            $dataList['characterList'] = Character::getPlayerAll($dataList['player']->playerId);
        }
        
        $this->render('playerDetail', array('playerData' => $dataList));
    }
    
    public function actionCharacterDetail() {
        $searchCondition = $_GET['data'];
        $dataList = array('hasCharacter'=>false, 'character' => null);
        $character = Yii::app()->objectLoader->load('Character', $searchCondition);
        if (!$character->isNew()) {
            $dataList['hasCharacter'] = true;
            $dataList['character'] = $character;
        }
        
        $this->render('characterDetail', array('characterData' => $dataList));
    }
}
