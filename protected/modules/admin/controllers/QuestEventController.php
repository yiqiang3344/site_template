<?php
class QuestEventController extends Controller{
	public $layout = '/questSet/layout';

	public function actionIndex(){
        $data = $this->getAllEventsData();
        
		$this->render('index',$data);
	}

    protected function getAllEventsData(){
    	$page = isset($_GET['page']) ? ($_GET['page']>0 ? $_GET['page'] : 1) : 1;
    	$perPage = QuestEventManager::PAGE_NUM;
        $questEventManager = new QuestEventManager();    	
        $allEvents = $questEventManager->getAllEvents();
        $totalCount = count($allEvents);
        //$allEvents = array_chunk($allEvents, QuestEventManager::PAGE_NUM, true);
        $eventList = $allEvents;//[$page - 1];
        $allQuestIds = QuestEventManager::getAllQuestIds();
        $pageInfo = Util::getPageInfo($totalCount, $page, $perPage);

        $startQuestId = isset($_REQUEST['startQuestId']) ? $_REQUEST['startQuestId'] : 0;
        $endQuestId = isset($_REQUEST['endQuestId']) ? $_REQUEST['endQuestId'] : 0;
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
        $filter = compact("startQuestId", "endQuestId", "status");
        array_walk($eventList, function(&$event, $key, $filter){
            $event['startTime'] = date('Y-m-d H:i:s', $event['startTime']);
            $event['endTime'] = date('Y-m-d H:i:s', $event['endTime']);
            extract($filter);
            $isAvailable = true;
            $questId = $event['quest']['questId'];
            if($isAvailable and $startQuestId and $questId<$startQuestId){
                $isAvailable = false;
            }
            if($isAvailable and $endQuestId and $questId>$endQuestId){
                $isAvailable = false;
            }
            if($isAvailable and $status and $status != $event['status']){
                $isAvailable = false;
            }
            $event['isAvailable'] = $isAvailable;
        }, $filter);

        $eventList = array_filter($eventList, function($event){
            return isset($event['isAvailable']) and $event['isAvailable'];
        });

        return compact("eventList", "pageInfo", "page", "allQuestIds", "filter");
    }

	public function actionAdd(){
        $questEventManager = new QuestEventManager();
		if($_POST){
            $selectedIds = array_unique($_POST['selectedId']);
            $startTime = strtotime($_POST['startTime1'] . ' ' . sprintf('%02d', $_POST['startTime2']) . ':00:00');
            $endTime = strtotime($_POST['endTime1'] . ' ' . sprintf('%02d', $_POST['endTime2']) . ':00:00');
            $attributes = array(
                'eventIds' => array(),
                'questIds' => $selectedIds,
                'startTime' => $startTime,
                'endTime' => $endTime,
            );
            $questEventForm = new QuestEventForm($attributes);
            $questEventForm->addQuestEvent();
			$this->redirect($this->createUrl('questEvent/index'));
		}else{
            $allQuests = Quest::getAllEventQuests();
            array_walk($allQuests, function(&$quest, $key){
                $quest['text'] = $quest['questId'] . '、' . $quest['questName'];
            });
			$this->render('add', array('allQuests'=>$allQuests));
		}		
	}
	public function actionEdit(){
		$events = isset($_GET['eventId']) ? explode(',', $_GET['eventId']) : null;
        if(!$events){
            throw new SException('param error');
        }
        $questEventManager = new QuestEventManager();
        $allEvents = $questEventManager->getAllEvents();
        array_walk($allEvents, function(&$event, $key){
            $event['startTime'] = date('Y-m-d H:i:s', $event['startTime']);
            $event['endTime'] = date('Y-m-d H:i:s', $event['endTime']);
            $event['text'] = $event['id'] . '、' . $event['quest']['questName'];
        });
        array_walk($events, function(&$value, $key, $allEvents){
            $eventId = $value;
            if(isset($allEvents[$eventId])){
                $value = $allEvents[$eventId];
            }else{
                $value = false;
            }
        }, $allEvents);
        $events = array_filter($events, function($event){
            return $event;
        });

		if(isset($_POST) and !empty($_POST)){
            $selectedIds = array_unique($_POST['selectedId']);
            $startTime = strtotime($_POST['startTime1'] . ' ' . sprintf('%02d', $_POST['startTime2']) . ':00:00');
            $endTime = strtotime($_POST['endTime1'] . ' ' . sprintf('%02d', $_POST['endTime2']) . ':00:00');
            $attributes = array(
                'eventIds' => $selectedIds,
                'questIds' => array(),
                'startTime' => $startTime,
                'endTime' => $endTime,
            );
            $questEventForm = new QuestEventForm($attributes);
            $questEventForm->updateQuestEvent();
            $url = $this->createUrl('questEvent/edit', array('eventId'=>implode(',', $selectedIds)));
            $url = urldecode($url);
            $this->redirect($url);
		}

		$this->render('edit',array('allEvents'=>$allEvents, 'events'=>$events));
	}
	
	public function actionDelete(){
        $eventId = isset($_GET['eventId']) ? $_GET['eventId'] : null;
        $eventIds = array();
        if($eventId){
            $eventIds = explode(',', $eventId);
        }
        $questEventManager = new QuestEventManager();
        $questEventManager->deleteEvents($eventIds);
		$this->echoJsonData();
	}
}
