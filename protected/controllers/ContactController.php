<?php
class ContactController extends Controller
{
    public function actionGo(){
        #input
        $urlName = $_GET['to'];
        #start
        $params = Contact::getInfoByUrlName($urlName);

        END:
        $bind = array(
            'params' => $params,
        );
        $this->render('go', $bind);
    }
}
