<?php
abstract class DataImport extends CComponent{
    private $_basePath = 'application.data.season2.alertDB';

    protected $scenario = 'web';

    protected $fileName;
    protected $tableName;
    protected $primaryKey;
    protected $debug = false;
    protected $debugAttribute = null;

    abstract public function getConfigData($file);
    abstract public function getInsertData($file);

    public function __construct(){
        $primaryKey = $this->getPrimaryKey();
        $this->primaryKey = $primaryKey;
		$path=Yii::getPathOfAlias($this->_basePath);
		if($path===false || !is_dir($path)){
			die('Error: The migration directory does not exist: '.$this->_basePath."\n");
        }
		$this->_basePath=$path;
    }

    public function setScenario($scenario){
        $this->scenario = $scenario;
    }

    public function isWebScenario(){
        return $this->scenario == 'web';
    }

    public function isConsoleScenario(){
        return $this->scenario == 'console';
    }

    public function getScenario(){
        return $this->scenario;
    }

    private function _deBug($value, $key){
        echo "$key:";

        if($this->isWebScenario()){
            echo '<br>';
        }elseif($this->isConsoleScenario()){
            echo "\n";
        }

        if($this->debugAttribute){
            print_r($value[$this->debugAttribute]);
        }else{
            print_r($value);
        }

        if($this->isWebScenario()){
            echo '<hr>';
        }elseif($this->isConsoleScenario()){
            echo "\n";
        }
    }

    protected function isRecordAvailable($record){
        if(!isset($record[0]) or !intval($record[0])){
            return false;
        }
        return true;
    }

    protected function parseData($file, $type){
        $datas = array();
        $handle = fopen($file,"r");
        $function = "get" . ucfirst($type) . "Data";
        while ($record = fgetcsv($handle, 1000, ",")) {
            if(!$this->isRecordAvailable($record)){
                continue;
            }
            $data = $this->$function($record);
            array_push($datas, $data);
        }
        fclose($handle);
        return $datas;
    }

    public function createConfig($file) {
        $data = $this->parseData($file, "config");
        if($this->debug){
            array_walk($data, array($this, '_deBug'));
            exit;
        }
        if($this->isWebScenario()){
            $html = CHtml::openTag('ol', array('start' => 1));
            foreach($data as $key=>$value) {
                $html .= CHtml::tag('li', array(), CHtml::tag('span', array(), CHtml::tag('span', array('class'=>'keyword'), "'$key'") . "=>'$value',"));
            }
            $html .= CHtml::closeTag('ol');
            return $html;
        }elseif($this->isConsoleScenario()){
            $content = array();
            foreach($data as $key=>$value){
                $value = "'$key'=>'$value'";
                array_push($content, $value);
            }
            $content = implode(",\n", $content);
            return $content;
        }
    }

    public function createInsertSql($file, $replace=false) {
        $columnNames = DbUtil::getTableColumns(Yii::app()->db, $this->tableName, false);
        $records = $this->parseData($file, "insert");
        foreach ($records as $key=>$record) {
            $insertData = array();
            if(!isset($record['createTime'])){
                $record['createTime'] = time();
            }
            foreach ($columnNames as $column) {
                if(isset($record[$column])){
                    $insertData[$column] = $record[$column];
                }
            }
            $insertDatas[] = $insertData;
        }
        if($this->debug){
            array_walk($insertDatas, array($this, '_deBug'));
            exit;
        }
        if(isset($this->fileName)){
            $content = $this->createInsertContent($insertDatas, array_keys($insertData));
            $file = $this->_basePath.DIRECTORY_SEPARATOR.$this->fileName.'.sql';
            file_put_contents($file, $content);
        }
        if($this->isWebScenario()){
            return $this->createInsertSqlString($insertDatas, array_keys($insertData), $replace);
        }
        if($this->isConsoleScenario()){
            return $this->createInsertContent($insertDatas, array_keys($insertData), $replace);
        }
    }

    public function createUpdateSql($file, $columns){
        if(empty($columns)){
            return $this->createInsertSql($file, true);
        }
        $columnNames = DbUtil::getTableColumns(Yii::app()->db, $this->tableName);
        $setColumns = array_intersect($columns, $columnNames);
        $records = $this->getInsertData($file);
        $updateDatas = array();
        foreach ($records as $key=>$record) {
            $updateData['set'] = array();
            foreach ($setColumns as $column) {
                if(isset($record[$column])){
                    $updateData['set'][$column] = $record[$column];
                }
            }
            $updateData['primaryKey'][$this->primaryKey] = $record[$this->primaryKey];
            $updateDatas[] = $updateData;
        }
        if($this->debug){
            array_walk($updateDatas, array($this, '_deBug'));
            exit;
        }
        if($this->isWebScenario()){
            return $this->createUpdateSqlString($updateDatas, $setColumns);
        }
        if($this->isConsoleScenario()){
            return $this->createUpdateContent($updateDatas, $setColumns);
        }
    }

    protected function getPrimaryKey(){
        $sql = "show columns from $this->tableName";
        $columns =  Yii::app()->db->createCommand($sql)->queryAll();
        $primaryColumn = array_filter($columns, function($column){
            return $column['Key'] == 'PRI';
        });
        if(count($primaryColumn)>1){
            $primaryKey = Util::getColumnByKey($primaryColumn, 'Field');
        }else{
            $primaryColumn = array_shift($primaryColumn);
            $primaryKey = $primaryColumn['Field'];
        }
        return $primaryKey;
    }

    protected function createInsertSqlString($insertDatas, $columns, $replace=false){
        if($replace){
            $method = "REPLACE";
        }else{
            $method = "INSERT";
        }
        $insertKey = implode('`,`', $columns);
        $sql = CHtml::openTag('ol', array('start'=>0));
        $sql .= CHtml::tag('li', array(), CHtml::tag('span', array('class'=>'keyword'), "$method INTO `$this->tableName` (`$insertKey`) VALUES"));
        $lastKey = count($insertDatas)-1;
        foreach($insertDatas as $key=>$insertData){
            array_walk($insertData, function(&$value){
                $value = "<span style='color:#7F3D00;'>" . htmlspecialchars($value) . "</span>";
            });
            $sqlstr = '(';
            $sqlstr .= implode(',', $insertData);
            $sqlstr .= ")" . (($key==$lastKey) ? ';' : ',');
            $sqls[] = CHtml::tag('li', array(), CHtml::tag('span', array(), $sqlstr));
        }
        $sql .= implode("", $sqls);
        $sql .= CHtml::closeTag('ol');
        return $sql;
    }

    protected function createInsertContent($insertDatas, $columns, $replace=false){
        if($replace){
            $method = "REPLACE";
        }else{
            $method = "INSERT";
        }
        $sql = '';
        $insertKey = implode('`,`', $columns);
        $sql = "$method INTO `$this->tableName` (`$insertKey`) VALUES \n";
        foreach($insertDatas as $key=>$insertData){
            $sqlstr = '(';
            $sqlstr .= implode(',', $insertData);
            $sqlstr .= ")";
            $sqls[] = $sqlstr;
        }
        $sql .= implode(",\n", $sqls);
        $sql .= ';';
        return $sql;
    }

    protected function createUpdateSqlString($updateDatas, $setColumns){
        $prefix = "<span style='color:rgb(255, 133, 0);'>update</span> `$this->tableName` <span style='color:rgb(255, 133, 0);'>set</span> ";
        $sqls = array();
        $sqlstring = CHtml::openTag('ol');
        foreach($updateDatas as $key=>$updateData){
            $set = $updateData['set'];
            array_walk($set, function(&$value, $key){
                $value = "`$key`=<span class='keyword'>" . htmlspecialchars($value) . "</span>";
            });
            $primaryKey = $updateData['primaryKey'];
            $sql = implode(', ', $set) . " <span style='color:rgb(255, 133, 0);'>where</span> `$this->primaryKey`=<span class='keyword'>" . $primaryKey[$this->primaryKey] . '</span>;';
            array_push($sqls, $sql);
        }
        foreach($sqls as $sql){
            $sqlstring .= CHtml::tag('li', array(), CHtml::tag('span', array(), $prefix . $sql));
        }
        $sqlstring .= CHtml::closeTag('ol');
        return $sqlstring;
    }

    protected function createUpdateContent($updateDatas, $setColumns){
        if(is_array($this->primaryKey)){
            $primaryKey = $this->primaryKey;
        }else{
            $primaryKey = array($this->primaryKey);
        }
        $template = "UPDATE `$this->tableName` SET {set} WHERE ";
        foreach($primaryKey as $key=>$pk){
            $conditions[] = "`$pk`={pk$key}";
        }
        $template .= implode(" AND ", $conditions) . ";";
        $values = array();
        foreach($updateDatas as $updateData){
            $set = $updateData['set'];
            foreach($setColumns as $attribute){
                $set[] = "`$attribute`=" . $set[$attribute];
            }
            $replace["{set}"] = implode(", ", $set);
            foreach($primaryKey as $key=>$pk){
                $replace["{pk$key}"] = $updateData['primaryKey'][$pk];
            }
            $update = strtr($template, $replace);
            array_push($values, $update);
        }
        $update = implode("\n", $values);
        return $update;
    }

    protected function getListString($list, $quote=true){
        $list = implode(",", explode("，", $list));
        if($quote){
            return $this->quote($list);
        }
        return $list;
    }

    protected function quote($value, $quote="'"){
        return $quote . $value . $quote;
    }
}
?>
