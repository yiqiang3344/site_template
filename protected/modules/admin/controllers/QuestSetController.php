<?php
class QuestSetController extends Controller{
	private $player ;
	public $layout='/questSet/layout';
	public function actionIndex(){
			$time = time();
			$year = isset($_GET['year']) ? $_GET['year'] : date('Y',$time);
			$month = isset($_GET['month']) ? $_GET['month'] : date('m',$time);
			$questQuery = new QuestQuery();
			$data = array(
                'year'=>$year,
                'month'=>$month,
                'questQuery'=>$questQuery,
			);
			$this->render('index',$data);
	}
	public function actionViewEvent(){
		$time = time();
		$year = isset($_GET['year']) ? $_GET['year'] : date('Y',$time);
		$month = isset($_GET['month']) ? $_GET['month'] : date('m',$time);
		$day = isset($_GET['day']) ? $_GET['day'] : date('d',$time);
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		
		$dateStartTime = strtotime($year.'-'.$month.'-'.$day);
		$questQuery = new QuestQuery();
		$allQuests = $questQuery->getDateQuest($dateStartTime, $type);
		
		$data = array('year'=>$year, 'month'=>$month, 'day'=>$day, 'quests'=>$allQuests, 'type'	=>$type, 'dateStartTime'=>$dateStartTime);
		$this->render('viewEvent',$data);
	}
	public function actionAddQuest(){
		$data = array();
		$rank = array(1,2,3,4,5,6,7,8,9,10);
		if($_POST){
			$type = $_POST['type'];
			$value = $_POST['value'];
			
			$selectedIds 		= $_POST['selectedId'];
			$startTime1			= $_POST['startTime1'];
			$startTime2			= $_POST['startTime2'];
			
			$endTime1			= $_POST['endTime1'];
			$endTime2			= $_POST['endTime2'];
			
			$startTime = strtotime($startTime1.' '.$startTime2.':00:00');
			$endTime = strtotime($endTime1.' '.$endTime2.':00:00');
            $attributes = array(
                'questIds' => implode(',', $selectedIds),
                'additionType' => $type,
                'additionValue' => $value,
                'startTime' => $startTime,
                'endTime' => $endTime,
                //'repeatType' => $repeatType,
            );
            $questDropAdditionForm = new QuestDropAdditionForm($attributes);
            $questDropAdditionForm->addDropAddition();
			$this->redirect($this->createUrl('questSet/viewEvent'));
		}else{
			$data['type'] = 'ap';
			$data['value'] = 0.5;
            foreach(array('ap', 'goldReward', 'expReward', 'reputationReward', 'characterDropRate', 'itemDropRate', 'contribution', 'pointReward') as $rewardType){
                if(isset($_GET[$rewardType])){
                    $data['type'] = $rewardType;
                    $data['value'] = $_GET[$rewardType];
                }
            }
            $data['rank']	= $rank;
            $questQuery = new QuestQuery();
            $events = $questQuery->getEventList();
            array_unshift($events, array('value'=>0, 'text'=>'请选择'));
            $data['eventList'] = $events;
			$this->render('addQuest',$data);
		}
	}
	public function actionCopyQuest(){
		$this->isAjax = true;
		$id = $_GET['id'];
        $questQuery = new QuestQuery();
        $questDropAddition = $questQuery->getQuestDropAddition($id);
        $questIds = $questDropAddition['questIds'];
		$startTime1= $_GET['startTime1'];
		$startTime2= $_GET['startTime2'];
		
		$endTime1= $_GET['endTime1'];
		$endTime2= $_GET['endTime2'];
		
        $startTime = strtotime($startTime1.' '.$startTime2.':00:00');
        $endTime = strtotime($endTime1.' '.$endTime2.':00:00');
        $attributes = array(
            'questIds' => $questIds,
            'additionType' => $_GET['type'],
            'additionValue' => $_GET['value'],
            'startTime' => $startTime,
            'endTime' => $endTime,
        );
		
        $questDropAdditionForm = new QuestDropAdditionForm($attributes);
        try{
            $questDropAdditionForm->addDropAddition();
        }catch(Exception $e){
            $data['flag'] = 0;
            $data['message'] = $e->getMessage();
            $this->echoJsonData($data);
        }
        $data['flag'] = 1;
        $data['message'] = '复制完毕!';
		$this->echoJsonData($data);
	}
	public function actionEditQuest(){
		$this->isAjax = true;
		$id = $_GET['id'];
        $questQuery = new QuestQuery();
        $questDropAddition = $questQuery->getQuestDropAddition($id);
        $questIds = $questDropAddition['questIds'];
		$startTime1= $_GET['startTime1'];
		$startTime2= $_GET['startTime2'];
		
		$endTime1= $_GET['endTime1'];
		$endTime2= $_GET['endTime2'];
		
        $startTime = strtotime($startTime1.' '.$startTime2.':00:00');
        $endTime = strtotime($endTime1.' '.$endTime2.':00:00');
        $attributes = array(
            'questIds' => $questIds,
            'additionType' => $_GET['type'],
            'additionValue' => $_GET['value'],
            'startTime' => $startTime,
            'endTime' => $endTime,
        );
		
        $questDropAdditionForm = new QuestDropAdditionForm($attributes);
        try{
            $questDropAdditionForm->updateDropAddition($id);
        }catch(Exception $e){
            $data['flag'] = 0;
            $data['message'] = $e->getMessage();
            $this->echoJsonData($data);
        }
        $data['flag'] = 1;
        $data['message'] = '更新完毕!';
		$this->echoJsonData($data);
	}
	public function actionDeleteQuest(){
		$id = $_GET['id'];
		$questQuery = new QuestQuery();
		$questQuery->deleteQuestEvent($id);
		$this->echoJsonData();
	}
	public function actionViewQuest(){
		$questId = $_GET['questId'];
		$quest = Quest::factory($questId);
		$this->render('viewQuest',array('quest'=>$quest));
	}
	public function actionGetQuestsByRank(){
		$rankId = $_GET['rankId'];
		$questQuery = new QuestQuery();
		$quests = $questQuery->getQuestsByRank($rankId);
		
		$data = array('quests'=>$quests);
		$html = $this->renderPartial('_getQuests',$data,true);
		$this->echoJsonData($html);
	}
	public function actionAllEvents(){
        $data = $this->getAllEventsData();
		$this->render('allEvents', $data);
	}
    protected function getAllEventsData(){
        $startEventId = isset($_POST['startEventId']) ? $_POST['startEventId'] : 0;
        $endEventId = isset($_POST['endEventId']) ? $_POST['endEventId'] : 0;
        $rewardType = isset($_POST['rewardType']) ? $_POST['rewardType'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : 0;
        $filter = compact("startEventId", "endEventId", "rewardType", "status");
		$questQuery = new QuestQuery();
		$allEvents = $questQuery->getAllEvents();
        array_walk($allEvents, function(&$event, $key, $filter){
            $event['dropAdditionType'] = QuestQuery::getEventType($event);
            extract($filter);
            $isAvailable = true;
            if($isAvailable and $startEventId and $key<$startEventId){
                $isAvailable = false;
            }
            if($isAvailable and $endEventId and $key>$endEventId){
                $isAvailable = false;
            }
            if($isAvailable and $rewardType and !$event[$rewardType]){
                $isAvailable = false;
            }
            if($isAvailable and $status and $status != $event['status']){
                $isAvailable = false;
            }
            $event['isAvailable'] = $isAvailable;
        }, $filter);
        $allEvents = array_filter($allEvents, function($event){
            return isset($event['isAvailable']) and $event['isAvailable'];
        });
        $data = compact("allEvents", "filter");
        return $data;
    }
	public function actionGetEventInfo(){
		$id = $_GET['id'];
        $do = isset($_GET['do']) ? $_GET['do'] : 'update';
		$questQuery = new QuestQuery();
		$questDropAddition = $questQuery->getQuestDropAddition($id);
		
		$data = array('questDropAddition'=>$questDropAddition, 'action'=>$do);
		$html = $this->renderPartial('_questInfo',$data,true,true);
		$this->echoJsonData($html);
	}
    public function actionCheckAdd(){
        $attributes = array(
            'questIds' => $_GET['questIds'],
            'startTime' => strtotime($_GET['startTime1'].' '.$_GET['startTime2'].':00:00'),
            'endTime' => strtotime($_GET['endTime1'].' '.$_GET['endTime2'].':00:00'),
            'additionType' => $_GET['additionType'],
            'additionValue' => $_GET['additionValue'],
        );
        $questDropAdditionForm = new QuestDropAdditionForm($attributes);
        try{
            $questDropAdditionForm->checkTime();
            $questDropAdditionForm->checkQuestDropAddition();
            $questDropAdditionForm->checkPointReward();
        }catch(Exception $e){
            $data['flag'] = 0;
            $data['message'] = $e->getMessage();
            $this->echoJsonData($data);
        }
        $data['flag'] = 1;
        $this->echoJsonData($data);
    }
	public function actionCheckTime($startTime1,$startTime2,$endTime1,$endTime2){
		$startTime = $startTime1.' '.$startTime2.':00:00';
		$endTime = $endTime1.' '.$endTime2.':00:00';
		$this->echoJsonData($this->checkTime($startTime, $endTime));
	}
	public function checkTime($startTime,$endTime){
		$warning = '';
		if(strtotime($endTime) <= strtotime($startTime)){
			$warning = '结束时间必须大于开始时间';
		}
		return $warning;
	}
}
