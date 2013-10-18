<?php
class QuestEventForm extends Component{
    public $eventIds;
    public $questIds;
    public $startTime;
    public $endTime;
    static protected $attributes = array('eventIds', 'questIds', 'startTime', 'endTime');
    static protected $table = 'questEvent';

    public function __construct($attributes){
        foreach(self::$attributes as $attribute){
            $this->$attribute = $attributes[$attribute];
        }
        if($this->eventIds and empty($this->questIds)){
            $eventIds = implode(',', $this->eventIds);
            $this->questIds = QuestEventManager::getQuestIdsByEventIds($eventIds);
        }
    }

    public function checkAdd(){
        if(empty($this->questIds)){
            throw new SException('请选择Quest');
        }
    }

    public function checkUpdate(){
        if(empty($this->eventIds)){
            throw new SException('请选择Event');
        }
    }

    public function checkTime () {
        if($this->startTime > $this->endTime){
            throw new SException('结束时间必须大于开始时间');
        }
	}
    
    public function checkQuestEvent($exceptIds=false) {
        $timeArray = array($this->startTime, $this->endTime);
        $questEventManager = new QuestEventManager();
        $existQuestIds = $questEventManager->getEventsByTimeArray($timeArray, $exceptIds);
        $intersect = array_intersect($existQuestIds, $this->questIds);
        if(!empty($intersect)){
            throw new SException(implode(',', $intersect) . "存在活动设置");
        }
	}

    public function addQuestEvent(){
        $this->checkTime();
        $this->checkQuestEvent();
        $this->checkAdd();
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $insertArr = array('startTime'=>$this->startTime, 'endTime'=>$this->endTime, 'createTime'=>time());
            foreach($this->questIds as $questId){
                $insertArr['questId'] = $questId;
                DbUtil::insert(Yii::app()->db, self::$table, $insertArr);
            }
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }

    public function updateQuestEvent(){
        $this->checkTime();
        $exceptIds = implode(',', $this->eventIds);
        $this->checkQuestEvent($exceptIds);
        $this->checkUpdate();
        $table = self::$table;
        $eventIds = implode(',', $this->eventIds);
        $sql = "update $table set startTime = :startTime, endTime = :endTime where id in($eventIds)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':startTime', $this->startTime);
        $command->bindParam(':endTime', $this->endTime);
        $command->execute();
    }
}
?>

