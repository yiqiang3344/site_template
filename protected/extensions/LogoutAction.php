<?php
class LogoutAction extends CAction
{
    public function run()
    {
        if(Yii::app()->user->logout()){
            $code = 1;
        }else{
            $code = 2;
        }
        $bind = array(
            'code' => $code,
            'userdata'=> Yii::app()->controller->getUD()
        );
        Yii::app()->controller->render($bind);
        Yii::app()->end();
    }
}