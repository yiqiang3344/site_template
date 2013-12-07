<?php
class Search extends CController
{
    public static function getCompanyListByName($name,$page,$pageSize){
        return Company::getListByPage('id,logo,name,star,score,beFixed,beRecommend,beGuarantee,clickCount,commentCount,abstract', 'name like \'%'.$name.'%\'', 'CASE WHEN name like \''.$name.'%\' THEN 0 WHEN name like \'%'.$name.'%\' THEN 1 ELSE 2 END, weight', array(), $page, $pageSize, false, false);
    }
}
