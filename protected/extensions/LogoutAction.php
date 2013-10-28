<?php
class LogoutAction extends CAction
{
    public function run()
    {
        Yii::app()->user->logout();
        $code = 1;
        $bind = array(
            'code' => $code,
            'userdata'=> Yii::app()->controller->getUD()
        );
        Yii::app()->controller->render($bind);
        Yii::app()->end();
    }
}