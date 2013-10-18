<?php
class DataJobCoRelation{
    static public function run($filename) {
        $columns = array(
            'jobId', 'jobName', 'job1', 'job2', 'job3', 'job4', 'job5', 'job6', 'job7', 'job8', 'job9', 'job10', 'job11', 'job12', 'job13', 'job14', 'job15', 'job16', 'job17'
        );

		$handle = fopen($filename,"r");
        //Titles
        fgetcsv($handle);
        fgetcsv($handle);

        while(($data = fgetcsv($handle)) != false){
            $result = array();
            for($i=0; $i<count($data); $i++){
                $result[$columns[$i]] = $data[$i];
            }
            self::updateJobCo($result);
        }
        fclose($handle);
    }

    static public function updateJobCo($data)
    {
        $command = Yii::app()->db->createCommand();
        $jobId = intval(substr($data['jobId'], 4, 3));
        foreach(range(1, 17) as $id){
            if($data['job'.$id] > 0){
                $command->update('job', array('job_' . $id => $data['job' . $id]), 'jobId=:jobId', array(':jobId'=>$jobId));
                $command->update('job', array('job_' . $jobId => $data['job' . $id]), 'jobId=:jobId', array(':jobId'=>$id));
            }
        }
    }
}
