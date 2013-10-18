<?php
class QuestEventManager extends Component{
    const PAGE_NUM = 50;
    static public $table = 'questEvent';

    public function getAllEvents(){
        $table = self::$table;
        $sql = "select * from $table where deleteFlag=0";
        $command = Yii::app()->db->createCommand($sql);
        $events = $command->queryAll();
        $questIds = Util::getColumnByKey($events, 'questId');
        $quests = Quest::getQuestsInfo($questIds);
        array_walk($events, function(&$event, $key, $quests){
            if(isset($quests[$event['questId']])){
                $quest = $quests[$event['questId']];
                $event['quest'] = $quest;
            }
            $startTime = $event['startTime'];
            $endTime = $event['endTime'];
            if(time()<$startTime){
                $event['status'] = 1;
            }elseif(time()>=$startTime and time()<=$endTime){
                $event['status'] = 2;
            }else{
                $event['status'] = 3;
            }
        }, $quests);
        array_filter($events, function($event){
            return isset($event['quest']);
        });
        usort($events, array($this, '_sortEvents'));
        $events = Util::changeArrayToHashByKey($events, 'id');
        return $events;
    }

    private function _sortEvents($a, $b){
		if ($a['endTime'] == $b['endTime']) {
            if($a['questId'] == $b['questId']){
                return 0;
            }
			return $a['questId'] < $b['questId'] ? -1 : 1;
		} else {
			return $a['endTime'] < $b['endTime'] ? -1 : 1;
		}
    }

    public function getEventByEventId($eventId){
        $events = $this->getAllEvents();
        $event = array();
        if(isset($events[$eventId])){
            $event = $events[$eventId];
        }
        return $event;
    }

    public function deleteEvents($eventIds){
        if(!empty($eventIds)){
            $eventIds = implode(',', $eventIds);
            $table = self::$table;
            $sql = "delete from $table where id in ($eventIds)";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
    }

    protected function getAllEventQuests(){
        $sql = "select questId from quest where questCategory=1 and deleteFlag=0";
        $command = Yii::app()->db->createCommand($sql);
        $questIds = $command->queryColumn();
        $quests = Quest::getQuestsInfo($questIds);
        return $quests;
    }

     static public function getEventsByTimeArray($timeArray, $exceptIds){
        $startTime = min($timeArray);
        $endTime = max($timeArray);
        $table = self::$table;
        $sql = "select questId from $table where ((startTime between $startTime and $endTime) or (endTime between $startTime and $endTime)) and deleteFlag = 0";
        if($exceptIds){
            $sql .= " and id not in($exceptIds)";
        }
        $command = Yii::app()->db->createCommand($sql);
        $questIds = $command->queryColumn();
        if($questIds){
            return array_unique($questIds);
        }
        return array();
    }

    static public function getQuestIdsByEventIds($eventIds){
        $table = self::$table;
        $sql = "select questId from $table where id in ($eventIds)";
        $command = Yii::app()->db->createCommand($sql);
        $questIds = $command->queryColumn();
        if($questIds){
            return array_unique($questIds);
        }
        return false;
    }

    static public function getAllQuestIds(){
        $table = self::$table;
        $sql = "select qe.questId from quest q,$table qe where qe.deleteFlag=0 and q.deleteFlag=0";
        $command = Yii::app()->db->createCommand($sql);
        $allQuestIds = $command->queryColumn();
        $allQuestIds = array_unique($allQuestIds);
        return $allQuestIds;
    }
}
?>
