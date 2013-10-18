<?php
class QuestDropAdditionForm extends Component{
    public $questIds;
    public $additionType;
    public $additionValue;
    public $startTime;
    public $endTime;
    protected $table = 'QuestDropAddition';

    public function __construct($attributes){
        foreach(array('questIds', 'additionType', 'additionValue', 'startTime', 'endTime') as $attribute){
            $this->$attribute = $attributes[$attribute];
        }
    }

    public function checkTime () {
        if($this->startTime > $this->endTime){
            throw new SException('结束时间必须大于开始时间');
        }
	}
    
    public function checkQuestDropAddition ($id=false) {
        $questQuery = new QuestQuery();
        $currentQuestIds = $questQuery->getExistEventsByTime(array($this->startTime, $this->endTime), $id);
        $intersect = array_intersect($currentQuestIds, explode(',', $this->questIds));
        if(!empty($intersect)){
            throw new SException(implode(',', $intersect) . '已经存在活动设置');
        }
	}

    public function checkPointReward(){
        if($this->additionType != 'pointReward'){
            return true;
        }
        $questQuery = new QuestQuery();
        $pointQuestIds = $questQuery->isPointQuests($this->questIds);
        $questIds = explode(',', $this->questIds);
        $diff = array_diff($questIds, $pointQuestIds);
        if(!empty($diff)){
            throw new SException(implode(',', $diff) . '不是积分活动');
        }
    }

    public function addDropAddition(){
        $this->checkTime();
        $this->checkQuestDropAddition();
        $this->checkPointReward();
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $columns = DbUtil::getTableColumns(Yii::app()->db, $this->table, false);
            $insertArray = array($this->additionType=>$this->additionValue, 'startTime'=>$this->startTime, 'endTime'=>$this->endTime,'questIds'=>$this->questIds);
            DbUtil::insert(Yii::app()->db, $this->table, $insertArray);
            $transaction->commit();
            return true;
        }catch(Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }

    public function updateDropAddition($id){
        $this->checkTime();
        $this->checkQuestDropAddition($id);
        $this->checkPointReward();
        $setArr = array('questIds'=>$this->questIds, $this->additionType=>$this->additionValue, 'startTime'=>$this->startTime, 'endTime'=>$this->endTime);
        $whereArr = array('id'=>$id);
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $this->initDropAddition($id);
            DbUtil::update(Yii::app()->db, $this->table, $setArr, $whereArr);
            $transaction->commit();
        }catch(Exception $e){
            throw $e;
            $transaction->rollback();
        }
    }

    public function initDropAddition($id){
        foreach(QuestQuery::$dropAdditionType as $type){
            $setArr[$type] = 0;
        }
        $whereArr = array('id'=>$id);
        DbUtil::update(Yii::app()->db, $this->table, $setArr, $whereArr);
    }
}
?>
