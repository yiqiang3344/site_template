<?php
class Company extends CActiveRecord
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
        return 'company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, openedTime', 'required'),
            array('openedTime', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
        );
    }

    public function defaultScope()
    {
        return array(
            // 'condition'=>"deleteFlag=0",//只查询没有删除的记录
        );
    }

    protected function beforeSave() {
        if($this->isNewRecord) {
            if($this->nameFirstLetter==''){
                $this->nameFirstLetter = Y::getFirstLetter($this->name);
            }
            $this->recordTime = Y::getTime();
        }
        return parent::beforeSave();
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public static function create($attributes){
        $m = new Company;
        $m->attributes = $attributes;
        if($m->save()){
            return array(1,array());
        }
        return array(2,$m->getErrors());
    }

    public function addCommentCount(){
        $this->updateCounters(array('commentCount'=>1));
    }

    public static function updateByIds($ids, $attributes){
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        return Company::model()->updateAll($attributes,$criteria);
    }
    

    public static function deleteByIds($ids){
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        return Company::model()->updateAll(array('deleteFlag'=>1),$criteria);
    }

    //根据条件获取指定列的列表
    public static function getList($select, $condition, $order='', $params=array()){
        if(is_string($condition)){
            $criteria=new CDbCriteria;
            $criteria->condition = $condition;
            $criteria->addCondition('deleteFlag=0');
        }else{
            $criteria = $condition;
        }
        $criteria->select=$select;
        $criteria->order=$order;
        $criteria->params=$params;
        return Company::model()->findAll($criteria);
    }

    //根据条件获取全部信息的列表并分页
    public static function getListByPage($select, $condition, $order, $params, $page, $page_size, $require_all){
        $criteria=new CDbCriteria;
        $criteria->condition = $condition;
        $criteria->addCondition('deleteFlag=0');
        $count = Company::model()->count($criteria,$params);
        if ($page_size == 0) {
            return array(
                'item_count' => $count, 
                'page' => 1, 
                'page_count' => 1, 
                'data' => self::getList($select,$criteria,$params), 
                'page_size' => $page_size
            );
        }
        $page_count = ceil($count / $page_size);
        $page = max( min($page,$page_count), 0);
        if ($page > 0) {
            list ( $offset, $limit ) = $require_all ? array(
                    0, $page * $page_size
                ) : array(
                    ($page - 1) * $page_size, $page_size
                );
            $criteria->select=$select;
            $criteria->order=$order;
            $criteria->offset=$offset;
            $criteria->limit=$limit;
            $criteria->params=$params;
            $data = Company::model()->findAll($criteria);
        } else {
            $data = array();
        }
        return array(
            "item_count" => $count, "page" => $page, "page_count" => $page_count, "data" => $data, "page_size" => $page_size
        );
    }












}