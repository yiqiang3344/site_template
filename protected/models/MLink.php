<?php
class MLink extends YActiveRecord
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
        return 'link';
    }

    public function scopes()
    {
        return array(
            'nodelete'=>array(
                'condition'=>'deleteFlag=0',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, url', 'required'),
            array('sort', 'safe'),
            array('name, url', 'unique'),
            array('name', 'length', 'max'=>64),
            array('url', 'length', 'max'=>128),
        );
    }

    protected function beforeSave() {
        if($this->isNewRecord) {
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

    public static function getListBySort(){
        return Y::modelsToArray(self::model()->nodelete()->findAll(array(
            'select'=>'id,name,url',
            'order'=>'sort desc',
        )));
    }

    public static function updateByIds($ids, $attributes){
        return Y::updateByIds(__CLASS__,$ids, $attributes);
    }

    public static function create($attributes){
        return Y::create(__CLASS__,$attributes);
    }

    public static function deleteByIds($ids){
        return Y::deleteByIds(__CLASS__,$ids);
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
