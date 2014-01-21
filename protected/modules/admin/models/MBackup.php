<?php
class MBackup extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'backup';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
        );
    }

    public function defaultScope()
    {
        return array(
            'condition'=>'deleteFlag=0',
        );
    }

    public function scopes()
    {
        return array(
        );
    }

    protected function beforeSave() {
        if($this->isNewRecord) {
            //uuid作为file
            //检查备份目录是否存在，不存在则创建
            $dir = Yii::app()->getBasePath().'/'.Yii::app()->params['backupDir'];
            !is_dir($dir) && mkdir($dir,0777);
            $this->file = $this->back();
            $this->createTime = Y::getTime();
        }
        return parent::beforeSave();
    }

    public function back(){
        //需要备份的表
        $tables = array(
            'activity',
            'comment',
            'company',
            'contact',
            'information',
            'inforCategory',
            'link',
            'user'
        );
        //uuid作为file
        $file = uniqid('backup', true).'.sql';
        //检查备份目录是否存在，不存在则创建
        $filePath = Yii::app()->getBasePath().'/'.Yii::app()->params['backupDir'].'/';
        !is_dir($filePath) && mkdir($filePath,0777);
        $filePath = $filePath.'/'.$file;
        $ss = '';
        foreach($tables as $t){
            $result = Yii::app()->db->createCommand("show create table {$t}")->queryRow();
            if(!$result){
                Y::end('table not exist.');
            }
            $str_create = $result['Create Table'];
            $ss .= "DROP TABLE IF EXISTS `{$t}`;\n";
            $ss .= $result['Create Table'] . ";\n";
            $rs = Yii::app()->db->createCommand("select * from {$t} where 1")->queryAll();
            if($rs){
                $arr = array();
                $i = 0;
                foreach($rs as $row){
                    foreach($row as $k => $v){
                        $row[$k] = "'" . str_replace(array("'", '"'), array("\\'", '\\"'), $v) . "'";
                    }
                    $arr[] = '('.implode(',', $row).')';
                    if(++$i%1000){
                        $ss .= "INSERT INTO `{$t}` VALUES ".implode(',', $arr).";";
                        $arr = array();
                    }
                }
                if($arr){
                    $ss .= "INSERT INTO `{$t}` VALUES ".implode(',', $arr).";";
                }
            }
        }
        if (file_exists($filePath)){
            @unlink($filePath);
        }
        $fp = fopen($filePath, "w+");
        fwrite($fp, $ss);
        return $file;
    }

    public function reback(){
        $ret = array(1,null);
        $file = Yii::app()->getBasePath().'/'.Yii::app()->params['backupDir'].'/'.$this->file;
        if(!is_file($file)){
            $ret = array(2,'备份文件不存在！');
        }
        Yii::app()->db->createCommand(file_get_contents($file))->execute();
        //修改数据表
        $this->lastRebackTime = Y::getTime();
        $this->save();
        return $ret;
    }

    public static function deleteByIds($ids){
        Y::begin();
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        //删除文件
        foreach(self::model()->findAll($criteria) as $m){
            $file = Yii::app()->getBasePath().'/'.Yii::app()->params['backupDir'].'/'.$m->file;
            is_file($file) && unlink($file);
        }
        self::model()->updateAll(array('deleteFlag'=>1,'file'=>''),$criteria);
        Y::commit();
        return true;
    }

    public static function updateByIds($ids){
        return Y::updateByIds(__CLASS__,$ids);
    }

    //根据条件获取指定列的列表
    public static function getList($select, $condition, $order='', $params=array(), $include_delete=false){
        return Y::getList(__CLASS__,$select, $condition, $order='', $params=array(), $include_delete);
    }

    //根据条件获取全部信息的列表并分页
    public static function getListByPage($select, $condition, $order, $params, $page, $page_size, $require_all, $include_delete=false){
        return Y::getListByPage(__CLASS__,$select, $condition, $order, $params, $page, $page_size, $require_all, $include_delete);
    }
}