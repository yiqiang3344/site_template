<?php
//自定义常用方法
class Y{
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
}