<?php
class Company extends YActiveRecord
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
            array('category, nameFirstLetter, weight, hasLogo, star, score, beFixed, beRecommend, beGuarantee, clickCount, COMMENTCount, platform, hasLicense, url, hasUrlPhoto, abstract, description', 'safe'),
            array('openedTime', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
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

    public function addCommentCount(){
        $this->updateCounters(array('commentCount'=>1));
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
