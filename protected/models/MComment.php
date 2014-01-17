<?php
class MComment extends YActiveRecord
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
        return 'comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, username, companyId, content, totalScore, scoreA, scoreB, scoreC', 'required'),
            array('totalScore, scoreA, scoreB, scoreC', 'numerical', 'integerOnly'=>true),
            array('content', 'length', 'min' =>1, 'max'=> 512),
            array('content', 'checkContent','on'=>'create'),
        );
    }

    public function checkContent(){
        if(($m = self::model()->find(array(
            'select'=>'recordTime',
            'condition'=>'userId=:userId and companyId=:companyId and deleteFlag=0',
            'params'=>array(':userId'=>$this->userId,':companyId'=>$this->companyId),
            'order'=>'id desc',
            'limit'=>1,
            ))) && Y::getTime()-$m->recordTime<30*24*3600){//同一个人对同一家公司一个月只能评论一次
            $this->addError('error',Yii::t('model','one month one comment'));
        }
    }

    protected function beforeSave() {
        if($this->isNewRecord) {
            //公司评论数增加
            MCompany::model()->findByPk($this->companyId)->addCommentCount();
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