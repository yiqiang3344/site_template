<?php
/**
 * 开发测试工具类 
 * 
 * 
 */

class CampaignController extends Controller {
	public function actionIndex(){
		$campaign = new Campaign();

		if(isset($_POST['submit'])){
			$fileName = $_FILES['campaign']["name"];
			if ($fileName) {
				$file = CUploadedFile::getInstanceByName('campaign');
				$file = $file->getTempName();
				$xmlData = file_get_contents($file);
				$content = $campaign->echoHtml($xmlData);
				//print_r($content);echo '<hr>';
				/*$xml = new DomDocument();
				$xml->loadXML($xmlData);
				$campaigns = $xml->getElementsByTagName('campaign');
				if (isset($_POST['campaignId']) and $_POST['campaignId']) {
					$content = $campaign->consoleData($campaign->getCampaignById($_POST['campaignId'], $campaigns));
				}else if (isset($_POST['campaignName']) and $_POST['campaignName']) {
					$content = $campaign->consoleData($campaign->getCampaignByName($_POST['campaignName'], $campaigns));
				} else {
					$content = $campaign->consoleData($campaign->getCampaign($campaigns));
				}*/
			}
		} else { 
			$content = $campaign->echoHtml();
		}
		$this->render('index', array('content'=>$content));
	}

	/*public function actionGetById() {
		$loadType = isset($_GET['loadType']) ? $_GET['loadType'] : 0;
		$campaignId = isset($_GET['campaignId']) ? $_GET['campaignId'] : null;
		$campaign = new Campaign();
		$content = $campaign->getCampaignById($campaignId, $loadType);
		$html = $campaign->consoleData($content);
		$this->echoJsonData($html);
	}

	public function actionGetByName() {
		$loadType = isset($_GET['loadType']) ? $_GET['loadType'] : 0;
		$campaignName = isset($_GET['campaignName']) ? $_GET['campaignName'] : null;
		$campaign = new Campaign();
		$content = $campaign->getCampaignByName($campaignName, $loadType);
		$html = $campaign->consoleData($content);
		$this->echoJsonData($html);
	}

	public function actionTest() {
		$campaign = new Campaign();
		$this->render('test', array('campaign'=>$campaign));
	}*/
}
?>
