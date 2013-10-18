<?php
class EventMigrate extends CFormModel{
    public $task;

    public $quest;

    public $startTime1;

    public $startTime2;

    public $endTime1;

    public $endTime2;

    public $fileName;

    protected $timezone = 9;

    public function rules(){
        return array(
            array('task, quest, fileName, startTime1, endTime1, startTime2, endTime2', 'required'),
        );
    }

    public function createMigrate(){
        $name = $this->getMigrateName();
        $task = $this->getMigrateData('task');
        $quest = $this->getMigrateData('quest');
        $questIds = $this->getQuestIds();
        $event = $this->createEvent($questIds);
        $content=strtr($this->getTemplate(), array('{ClassName}'=>$name, '{task}'=>$task, '{quest}'=>$quest, '{event}'=>$event, '{questIds}'=>implode(',', $questIds)));
        return compact("name", "content");
    }

    public function getMigrateData($name){
        $fileName = get_class() . "[$name]";
        $modelName = ucfirst($name) . "Data";
        $dataModel = new $modelName;
        $dataModel->setScenario('console');
        return $dataModel->createInsertSql($this->$name);
    }

    protected function getEventTime(){
        $minus = $this->timezone - 8;
        $startTime = $this->startTime1 . " " . sprintf("%02d:00:00", $this->startTime2);
        $endTime = $this->endTime1 . " " . sprintf("%02d:00:00", $this->endTime2);
        $startTime = strtotime("- $minus hour", strtotime($startTime));
        $endTime = strtotime("- $minus hour", strtotime($endTime));
        return array($startTime, $endTime);
    }

    protected function getMigrateName(){
        if(preg_match('/^(m(\d{6}_\d{6})_.*?)$/',$this->fileName,$matches) and isset($matches[2])){
            return $this->fileName;
        }else{
            $name = 'm' . gmdate('ymd_His') . '_' . $this->fileName;
            return $name;
        }
    }

    protected function createEvent($questIds){
        list($startTime, $endTime) = $this->getEventTime();
        $createTime = time();
        foreach($questIds as $questId){
            $events[] = "($questId, $startTime, $endTime, $createTime, 0)";
        }
        $events = implode(",\n", $events);
        $event = <<<EVENT
insert into `questEvent` (`questId`, `startTime`, `endTime`, `createTime`, `deleteFlag`) values
$events;
EVENT;
        return $event;
    }

    protected function getQuestIds(){
        $fileName = get_class() . "[quest]";
        $file = CUploadedFile::getInstanceByName($fileName);
        $file = $file->getTempName();
        $questIds = array();
        $handle = fopen($file,"r");
        $data = fgetcsv($handle, 1000, ",");
        $data = fgetcsv($handle, 1000, ",");

        while ($data = fgetcsv($handle, 1000, ",")) {
            if(!isset($data[1]) or !$data[1]){
                continue;
            }
            array_push($questIds, $data[0]);
        }
        fclose($handle);
        return $questIds;
    }

	protected function getTemplate(){
        return <<<TEMPLATE
<?php

class {ClassName} extends CDbMigration
{
	public function up()
	{
        \$task = <<<TASK
            {task}
TASK;
        \$this->execute(\$task);
        \$quest = <<<QUEST
            {quest}
QUEST;
        \$this->execute(\$quest);
        \$event = <<<EVENT
            {event}
EVENT;
        \$this->execute(\$event);
	}

	public function down()
	{
        \$questIds = array({questIds});
        \$this->delete('task', array('in', 'questId', \$questIds));
        \$this->delete('quest', array('in', 'questId', \$questIds));
        \$this->delete('questEvent', array('in', 'questId', \$questIds));
	}
}
TEMPLATE;
	}
}
?>
