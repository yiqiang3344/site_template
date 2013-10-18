<?php
class YearEndEventForm extends CFormModel{
    public $questId;
    public $globalAccumulateNum;
    public $rank;
    public $insertFlag=0;

	public function rules() {
		return array(
            array('questId, globalAccumulateNum,rank,insertFlag', 'required'),
            array('questId', 'checkQuestId'),
            array('rank', 'checkRank'),
		);
	}

    public function checkQuestId () {
        if (!$this->hasErrors()) {
			if (intval($this->questId)==0) {
				$this->addError('questId','questId can not be 0');
			}
            if($this->isQuestExist()){
				$this->addError('questId',"quest $this->questId is exist");
            }
		}
	}

    public function checkRank () {
        if (!$this->hasErrors()) {
			if (intval($this->rank)==0) {
				$this->addError('rank','rank can not be 0');
			}
		}
	}

    public function insertData(){
        $data['questId'] = intval($this->questId);
        $data['globalAccumulateNum'] = intval($this->globalAccumulateNum);
        $data['createTime'] = time();
        $data['rank'] = intval($this->rank);
        $insertKey = implode('`,`', array_keys($data));
        $insertValues = implode(',', array_values($data));
        $sql = "INSERT INTO `yearEndEvent` (`" . $insertKey . "`) VALUES(" . $insertValues . ")";
        if($this->insertFlag){
            $eventId = DbUtil::insert(Yii::app()->db, 'yearEndEvent', $data, true);
            $event = $this->getEventByEventId($eventId);
        }
        return $sql;
    }

    protected function getEventByEventId($eventId){
        $cmd = Yii::app()->db->createCommand('select * from yearEndEvent where eventId = :eventId');
        $cmd->bindParam(':eventId', $eventId);
        return $cmd->queryRow();
    }

    protected function isQuestExist(){
        $cmd = Yii::app()->db->createCommand('select eventId from yearEndEvent where questId = :questId');
        $cmd->bindParam(':questId', $this->questId);
        return $cmd->queryScalar();
    }
}
?>
