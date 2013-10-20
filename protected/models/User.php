<?php
class User extends CActiveRecord
{
	//注册
    public $passwordConfirm;
    public $verifyCode;
    //登录
    public $remember;
    
    private $_identity;
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
            return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('username, password', 'required'),
                    array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
                    array('passwordConfirm', 'required', 'on' => 'register'),
                    array('username', 'unique', 'on' => 'register'),
                    array('passwordConfirm', 'compare', 'compareAttribute' => 'password', 'on' => 'register'),
                    array('password', 'length', 'min' => 4, 'max' => 15, 'on' => 'register'),
                    array('remember', 'boolean', 'on' => 'login'),
                    array('password', 'authenticate', 'on' => 'login'),
            );
    }
    
    protected function beforeSave() {
            if($this->isNewRecord) {
                    $this->password = $this->encrypPassword($this->password);
                    $this->recordTime = Y::getTime();
            }
            return parent::beforeSave();
    }
    
    public function authenticate()
    {
            if(!$this->hasErrors()) {
                    $this->_identity = new UserIdentity($this->email, $this->password);
                    
                    if($this->_identity->authenticate() !== UserIdentity::ERROR_NONE) {
                            $this->addError('password', Yii::t('model','password error'));
                    }
            }
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

    public function validatePassword($password)
    {
            if($this->encrypPassword($password) === $this->password) {
                    return true;
            }
            else {
                    return false;
            }
    }

    private function encrypPassword($password){
    	return md5($password);
    }
    
    public function login()
    {
            if($this->_identity === null) {
                    $this->_identity = new UserIdentity($this->username, $this->password);
                    $this->_identity->authenticate();
            }
            
            if($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
                    $duration = $this->remember ? 3600 * 24 * 30 : 0; // 30天
                    Yii::app()->user->login($this->_identity, $duration);
                    return true;
            } else {
                    return false;
            }
    }
}