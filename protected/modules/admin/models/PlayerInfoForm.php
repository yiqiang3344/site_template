<?php

class PlayerInfoForm extends CFormModel {
	public $playerName;
	private $db;
	private $worldDb;
    
	public function rules() {
		return array(
            array('playerName', 'required'),
		);
	}

	public function init() {
	    $this->db = Yii::app()->db;
		$this->worldDb = Yii::app()->worldDb;
	}

	public function getPlayerInfo() {	    
		$playerInfo['playerName'] = $this->playerName;
		$sql = 'select * from player left join playerLogin on player.playerId=playerLogin.playerId where player.playerName = :playerName';
		$command = $this->db->createCommand($sql);
		$command->bindParam(':playerName', $this->playerName);
		$result = $command->queryRow();
		$playerInfo['playerId'] = $result['playerId'];
		$playerInfo['userId'] = $result['userId'];
		$playerInfo['lastLoginTime'] = date("Y-m-d H:i:s", $result['lastLoginTime']);
		$sql = 'select * from userUID where userId = :userId';
		$command = $this->worldDb->createCommand($sql);
		$command->bindParam(':userId', $playerInfo['userId']);
		$result = $command->queryRow();
		$playerInfo['deviceId'] = $result['deviceId'];
		return $playerInfo;
	}
}
?>