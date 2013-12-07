<?php
class ContactController extends Controller
{
    public function actionGo(){
        #input
        $urlName = $_GET['to'];
        #start
        if(!$urlName){
            Y::end('illegal access.');
        }
        $params = Contact::getInfoByUrlName($urlName);

        $stageName = $params['name'];
        END:
        $this->setStageList($stageName);
        $bind = array(
            'params' => $params,
        );
        $this->render('go', $bind);
    }
}
