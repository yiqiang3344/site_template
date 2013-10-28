<?php
class Search extends CController
{
    public static function getCompanyListByName($name){
        return Y::modelsToArray(Company::model()->findAll(array(
            'select'=>'id,category,name,hasLogo,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,platform,hasLicense,openedTime,url,abstract',
            'condition'=>'name like \'%'.$name.'%\'',
            'order'=>'CASE WHEN name like \''.$name.'%\' THEN 0 WHEN name like \'%'.$name.'%\' THEN 1 ELSE 2 END, weight')));
    }
}
