<?php
Class QuestQuery{
	public $db;
    static public $table = 'QuestDropAddition';
    static public $dropAdditionType = array('ap', 'goldReward', 'expReward', 'reputationReward', 'characterDropRate', 'itemDropRate', 'contribution', 'pointReward');
	public function __construct(){
		$this->db = Yii::app()->db;
	}
	public function getDateQuest($dateStartTime, $type=''){
		$dateEndTime = $dateStartTime + 3600*24;
		$quests = $this->getOnlyQuest($dateStartTime,$dateEndTime, $type);
		return $quests;
	}

	public function getOnlyQuest($dateStartTime,$dateEndTime, $type){
        $condition = '';
        if($type){
            $condition .= ' and '.$type.' >0';
        }
        $sql = "select * from " . self::$table . " where deleteFlag=0 and ((startTime>=:dateStartTime and startTime <:dateEndTime) OR (endTime>:dateStartTime and endTime <=:dateEndTime) OR (startTime<=:dateStartTime and endTime >=:dateEndTime))" . $condition;
		$command = $this->db->createCommand($sql);
		$command->bindValue(":dateStartTime",$dateStartTime);
		$command->bindValue(":dateEndTime",$dateEndTime);
        $results = $command->queryAll();
        $results = $this->getEventsInfo($results);
        return $results;
	}

    protected function getEventsInfo($events = array()){
        $questIds = array();
        foreach($events as $event){
            $questIds = array_merge($questIds, explode(',', $event['questIds']));
        }
        $questsInfo = Quest::getQuestsInfo($questIds);
        array_walk($events, function(&$event, $key, $questsInfo){
            $quests = explode(',', $event['questIds']);
            foreach($quests as $key=>&$quest){
                if(isset($questsInfo[$quest])){
                    $quest = $questsInfo[$quest];
                    $quest['questTitleText'] = Yii::t('QuestName', $quest['questTitle']);
                }else{
                    unset($quests[$key]);
                }
            }
            $quests = Util::changeArrayToHashByKey($quests, 'questId');
            $event['questIds'] = implode(',', array_keys($quests));
            $event['quests'] = $quests;
        }, $questsInfo);
        array_filter($events, function($event){
            return !empty($event['quests']);
        });
        $events = Util::changeArrayToHashByKey($events, 'id');
        return $events;
    }

    public function getEventList($playerId = 0){
        $sql = "select qe.*,questTitle from quest q, questEvent qe where qe.questId=q.questId and q.questCategory=1 and q.deleteFlag=0 and qe.deleteFlag=0 and endTime > :time";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':time', time());
        $events = $command->queryAll() ? $command->queryAll() : array();
        array_walk($events, function(&$value, $key){
            $value['value'] = $value['questId'];
            $startTime = date('Y-m-d', $value['startTime']);
            $endTime = date('Y-m-d', $value['endTime']);
            $value['text'] = $value['questId'] . '、' . Yii::t('QuestName', $value['questTitle']) . '(' . $startTime . '~' . $endTime . ')';
        });
        return  $events;
    }

	public function getQuestsByRank($rankId){
        $command = Yii::app()->db->createCommand("SELECT questId,questTitle FROM quest WHERE rank=:rank AND deleteFlag=0 and questCategory=0 order by questId");
        $command->bindParam(':rank',$rankId);
        return  $command->queryAll();
	}
	public function getQuestDropAddition($id){
        $sql = "select * from " . self::$table . " where id = :id";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':id',$id);
        $event = $command->queryAll();
        $event = $this->getEventsInfo($event);
        $event = array_shift($event);
		return $event;
	}
	public function deleteQuestEvent($id){
		$command = Yii::app()->db->createCommand("
			delete from " . self::$table . " where id=:id
		");
		$command->bindValue(":id",$id);
		$command->execute();
	}
	public function getAllEvents(){
        $sql = "select * from " . self::$table . " where deleteFlag=0";
		$command = Yii::app()->db->createCommand($sql);
        $events = $command->queryAll();
        $events = $this->getEventsInfo($events);
        array_walk($events, function(&$event, $key){
            $startTime = $event['startTime'];
            $endTime = $event['endTime'];
            if(time()<$startTime){
                $event['status'] = 1;
            }elseif(time()>=$startTime and time()<=$endTime){
                $event['status'] = 2;
            }else{
                $event['status'] = 3;
            }
        });
		return $events;
	}
    public function getExistEventsByTime($timeArray, $exceptId){
        $sql = "select * from " . self::$table . " where deleteFlag = 0";
		if($exceptId){
			$sql.=' and id !='.$exceptId;
		}
        $command = Yii::app()->db->createCommand($sql);
        $records = $command->queryAll();
        $events = $this->getEventsInfo($records);
        array_walk($events, function(&$event, $key){
            $startTime = $event['startTime'];
            $endTime = $event['endTime'];
            foreach($event['quests'] as &$quest){
                $quest['startTime'] = $startTime;
                $quest['endTime'] = $endTime;
            }
            $event = $event['quests'];
        });
        $quests = array();
        foreach($events as $event){
            $quests = array_merge($quests, $event);
        }
        $questIds = array();
        foreach($quests as $quest){
            if(!(max($timeArray)<min($quest['startTime'], $quest['endTime']) or min($timeArray)>max($quest['startTime'], $quest['endTime']))){
                $questIds[] = $quest['questId'];
            }
        }
        return $questIds;
    }

    public function isPointQuests($questIds){
        $sql = "select questId from quest where questId in ($questIds) and creditReward>0 and pointType>0";
        $command = Yii::app()->db->createCommand($sql);
        $pointQuestIds = $command->queryColumn();
        return $pointQuestIds ? $pointQuestIds : array();
    }

    static public function getAllEventIds(){
        $sql = "select id from " . self::$table . " where deleteFlag=0";
		$command = Yii::app()->db->createCommand($sql);
        return $command->queryColumn();
    }

    static public function getEventType($event){
        foreach(self::$dropAdditionType as $type){
            if($event[$type]){
                return Yii::t('AdminModule.Quest', 'drop addition '.$type, array('{num}'=>$event[$type]));
            }
        }
        return false;
    }
}
