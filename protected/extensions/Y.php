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

    function FUE($hash,$times=1) {
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

    function cp($src, $columns, &$dest = array()) {
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