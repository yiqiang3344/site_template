<?php
class DataImportController extends Controller{
    public function actionIndex(){
        $model = new DataImportForm;
        $data = compact("model");
        if(isset($_POST[get_class($model)]) and isset($_FILES[get_class($model)])) {
            $model->attributes = $_POST[get_class($model)];
            $model->attributes = $_FILES[get_class($model)]['tmp_name'];
            if($model->validate()) {
                $data['sql'] = $model->createSql();
                $data['copy'] = $model->createContent();
        	}
		}
        $this->render('index', $data);
    }

    public function actionConfig(){
        if(isset($_REQUEST['submit'])){
            $fileName = $_FILES["file"]["name"];
            $modelName = isset($_REQUEST['modelName']) ? $_REQUEST['modelName'] : null;
            $args = isset($_REQUEST['args']) ? $_REQUEST['args'] : null;
            $args = explode(',', $args);
            if ($fileName) {
                $file = CUploadedFile::getInstanceByName('file');
                $file = $file->getTempName();
                $data = $this->getDataFromCsv($file);
                $model = new $modelName($data, $args);
                $model->setScenario('web');
                $data['html'] = $model->createConfig();
            }
        }
        $data['modelList'] = $this->getConfigList();
        $this->render('config', $data);
    }

    public function actionEventMigrate(){
        $model = new EventMigrate;
        $model->init();
        $data = compact("model");

        if (isset($_POST[get_class($model)]) and isset($_FILES[get_class($model)])) {
            $model->attributes = $_POST[get_class($model)];
            $model->attributes = $_FILES[get_class($model)]['tmp_name'];
            if ($model->validate()) {
                try{
                    $migrate = $model->createMigrate();
                }catch(Exception $e){
                    throw $e;
                }
                Header("Content-type: application/octet-stream" );
                Header("Accept-Ranges: bytes" );
                Header("Content-Disposition: attachment; filename=" . $migrate['name'] . ".php");
                echo $migrate['content'];
                exit;
        	}
		}
        $this->render('eventMigrate', $data);
    }

    protected function getConfigList(){
        return array(
            '0' => array('value'=>'0', 'text'=>'请选择模型'),
            '1' => array('value'=>'StoreyShopGenerate', 'text'=>'storey shop'),
            '2' => array('value'=>'QuestFragmentGenerate', 'text'=>'quest fragment'),
        );
    }

    protected function getDataFromCsv($file){
        $configData = array();
        $handle = fopen($file, 'r');
        while($data = fgetcsv($handle, 1000, ',')){
            array_push($configData, $data);
        }
        fclose($handle);
        return $configData;
    }
}
?>
