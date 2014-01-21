<?php
//自定义常用方法
class Y{
    public static function xexplode($delimiter, $string){
        if(!$string){
            return array();
        }
        return explode($delimiter, $string);
    }

    public static function getUrl($c,$a=null,$p=array()){
        if($a){
            $ret = Yii::app()->getBaseUrl().'/'.$c.'/'.$a;
            $l = array();
            foreach($p as $k=>$v){
                $l[] = urlencode ( $k ) . "=" . urlencode ( $v );
            }
            $p && ($ret .= '?'.implode('&', $l));
        }else{
            //非开发环境中的css和js都是压缩过的,开发环境中则不压缩
            if(Yii::app()->language=='dev'){
                if(!preg_match('{^(js/(jquery|all|main|tools|url)\.|css|img|images)}',$c)){
                    //开发语言中需要翻译的
                    $c = Yii::app()->language.'/'.$c;
                }
            }else{
                $min_name = str_replace(array('.js','.css'),array('.min.js','.min.css'),$c);
                if(preg_match('{^(js/(jquery|all)\.|css)}',$c)){
                    //非开发语言中不需要翻译的
                    $c = 'script/'.basename($min_name);
                }elseif(preg_match('{^js}',$c)){
                    //非开发语言中需要翻译的
                    $c = Yii::app()->language.'/'.$min_name;
                }
            }
            $md5 = @md5_file ($c);
            $ret = Yii::app()->getBaseUrl().'/'.$c.($md5 ? '?v=' . substr ( $md5, 0, 8 ) : '');
        }
        return $ret;
    }

    static public function end($message,$exception=S::EXCEPTION_SITE){
        if(self::$_transaction){
            self::$_transaction->rollback();
            self::$_transaction = null;
        }

        if(is_array($message)){
            $l = array();
            foreach($message as $s){
                $l[] = $s[0];
            }
            $message = implode(';',$l);
        }

        if($exception==S::EXCEPTION_SITE){
            if(YII_DEBUG){
                throw new YException($message);//操作异常
            }else{
                header('Location:'.Y::getUrl('Site','Error'));
                Yii::end();
            }
        }else{
            throw new CException($message);//代码异常
        }
    }

    static public function getFirstLetter($str){
        $fchar = ord($str{0});
        if($fchar >= ord("A") and $fchar <= ord("z") )
            return strtoupper($str{0});
        $s1 = iconv("UTF-8","gb2312", $str);
        $s2 = iconv("gb2312","UTF-8", $s1);
        if($s2 == $str){
            $s = $s1;
        }else{
            $s = $str;
        }
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if($asc >= -20319 and $asc <= -20284) return "A";
        if($asc >= -20283 and $asc <= -19776) return "B";
        if($asc >= -19775 and $asc <= -19219) return "C";
        if($asc >= -19218 and $asc <= -18711) return "D";
        if($asc >= -18710 and $asc <= -18527) return "E";
        if($asc >= -18526 and $asc <= -18240) return "F";
        if($asc >= -18239 and $asc <= -17923) return "G";
        if($asc >= -17922 and $asc <= -17418) return "I";
        if($asc >= -17417 and $asc <= -16475) return "J";
        if($asc >= -16474 and $asc <= -16213) return "K";
        if($asc >= -16212 and $asc <= -15641) return "L";
        if($asc >= -15640 and $asc <= -15166) return "M";
        if($asc >= -15165 and $asc <= -14923) return "N";
        if($asc >= -14922 and $asc <= -14915) return "O";
        if($asc >= -14914 and $asc <= -14631) return "P";
        if($asc >= -14630 and $asc <= -14150) return "Q";
        if($asc >= -14149 and $asc <= -14091) return "R";
        if($asc >= -14090 and $asc <= -13319) return "S";
        if($asc >= -13318 and $asc <= -12839) return "T";
        if($asc >= -12838 and $asc <= -12557) return "W";
        if($asc >= -12556 and $asc <= -11848) return "X";
        if($asc >= -11847 and $asc <= -11056) return "Y";
        if($asc >= -11055 and $asc <= -10247) return "Z";
        return null;
    }
    
    public static function pinyin($zh){
         $ret = "";
         $s1 = iconv("UTF-8","gb2312", $zh);
         $s2 = iconv("gb2312","UTF-8", $s1);
         if($s2 == $zh){$zh = $s1;}
         for($i = 0; $i < strlen($zh); $i++){
             $s1 = substr($zh,$i,1);
             $p = ord($s1);
             if($p > 160){
                 $s2 = substr($zh,$i++,2);
                 $ret .= getFirstLetter($s2);
             }else{
                 $ret .= $s1;
             }
         }
         return $ret;
    }

    public static function create($model_name,$attributes){
        $m = new $model_name;
        $m->attributes = $attributes;
        if($m->save()){
            return array(1,array());
        }
        return array(2,$m->getErrors());
    }

    public static function updateByIds($model_name, $ids, $attributes){
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        return $model_name::model()->updateAll($attributes,$criteria);
    }

    public static function deleteByIds($model_name,$ids){
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        return $model_name::model()->updateAll(array('deleteFlag'=>1),$criteria);
    }

    //根据条件获取指定列的列表
    public static function getList($model_name,$select, $condition, $order='', $params=array(), $include_delete=false){
        if($condition && is_string($condition)){
            $criteria=new CDbCriteria;
            $criteria->condition = $condition;
            $include_delete || $criteria->addCondition('deleteFlag=0');
        }else{
            $criteria = $condition;
        }
        $criteria->select=$select;
        $criteria->order=$order;
        $criteria->params=$params;
        return Y::modelsToArray($model_name::model()->findAll($criteria));
    }

    //根据条件获取全部信息的列表并分页
    public static function getListByPage($model_name,$select, $condition, $order, $params, $page, $page_size, $require_all, $include_delete=false){
        $criteria=new CDbCriteria;
        $condition && ($criteria->condition = $condition);
        $include_delete || $criteria->addCondition('deleteFlag=0');
        if ($page_size == 0) {
            return array(
                'item_count' => $count, 
                'page' => 1, 
                'page_count' => 1, 
                'data' => $model_name::getList($select,$criteria, $order, $params,$include_delete), 
                'page_size' => $page_size
            );
        }
        $count = $model_name::model()->count($criteria,$params);
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
            $data = Y::modelsToArray($model_name::model()->findAll($criteria));
        } else {
            $data = array();
        }
        return array(
            "item_count" => $count, "page" => $page, "page_count" => $page_count, "data" => $data, "page_size" => $page_size
        );
    }

    static public function modelsToArray($models){
        $arr = array();
        if(is_object($models)){
            foreach(array_merge(get_object_vars($models),$models->attributes) as $k=>$v){
                $v!==null && ($arr[$k] = $v);
            }
        }elseif(is_array($models)){
            foreach ($models as $k => $m) {
                $arr[$k] = self::modelsToArray($m);
            }
        }
        return $arr ? $arr : $models;
    }


    static private $_transaction=null;
    //开启事物
    static public function begin(){
        if(self::$_transaction!==null){
            Y::end(Yii::t('sys','transaction already open.'),S::EXCEPTION_CODE);
            return;
        }
        self::$_transaction = Yii::app()->db->beginTransaction();
        return self::$_transaction;
    }

    //提交事物
    static public function commit(){
        if(self::$_transaction===null){
            Y::end(Yii::t('sys','transaction not open.'),S::EXCEPTION_CODE);
            return;
        }
        self::$_transaction->commit();
        self::$_transaction = null;
        return true;
    }

    //回滚事物
    static public function rollback(){
        if(self::$_transaction===null){
            Y::end(Yii::t('sys','transaction not open.'),S::EXCEPTION_CODE);
            return;
        }
        self::$_transaction->rollback();
        self::$_transaction = null;
        return true;
    }
    
    //$time=getTime();得到当前时间,允许缓存
    //$time=getTime();得到当前时间,不允许缓存
    //$time=getTime('2010-1-1'); 等同于 strtotime
    static public function getTime($refresh = false){
        $add_time = 24*60*60*0 + 60*60*0 + 60*0;
        if ($refresh !== true && $refresh !== false) {
            return strtotime($refresh);
        }
        if (!defined("CUR_TIME") || $refresh) {
            $dba = Yii::app()->db;
            //sql 结果为字符串型，在js中做数学运算会出问题
            $t = (int)$dba->createCommand('select unix_timestamp();')->queryScalar()+$add_time;
            if (!defined("CUR_TIME")) {
                define("CUR_TIME", $t);
            }
            return $t;
        }
        return CUR_TIME;
    }

    static function getIp(){
        if(getenv('HTTP_CLIENT_IP')) { 
            $onlineip = getenv('HTTP_CLIENT_IP'); 
        } elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
            $onlineip = getenv('HTTP_X_FORWARDED_FOR'); 
        } elseif(getenv('REMOTE_ADDR')) { 
            $onlineip = getenv('REMOTE_ADDR'); 
        } else { 
            $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR']; 
        }
        return $onlineip;
    }

    public static function FUE($hash,$times=1) {
        for($i=$times;$i>0;$i--) {
            // Encode with base64...
            $hash=base64_encode($hash);
            // and md5...
            $hash=md5($hash);
            // sha1...
            $hash=sha1($hash);
            // sha256... (one more)
            $hash=hash("sha256", $hash);
            // sha512
            $hash=hash("sha512", $hash);
        }
        return $hash;
    }

    public static function cp($src, $columns, &$dest = array()) {
        foreach ($columns as $column) {
            if (is_array($src)) {
                $dest[$column] = $src[$column];
            } else if (is_object($src)) {
                $dest[$column] = $src->$column;
            } else {
                die("cp:src type error");
            }
        }
        return $dest;
    }

}