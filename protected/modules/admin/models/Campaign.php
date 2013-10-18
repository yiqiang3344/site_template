<?php
class Campaign {
	public static $siteId = 1175;
	public static $siteKey = 'b96a528f77f5e6b22c6b5ac96fc94100';
	public static $mediaId = 885;
	public static $tableName = 'appdriverCampaign';

	
    public function usage() {
        echo "Usage: clearDeletedCharacter start\n";
    }

	public function getCampainUrl() {
		//return 'http://192.168.2.160/season2/seven2/xml/aaa.xml';
		$digest = hash("sha256", self::$mediaId . ":" . self::$siteKey);
		$campainUrl = 'http://appdriver.jp/4.0.'.self::$siteId.'ads?media_id='.self::$mediaId.'&digest='.$digest;
		return $campainUrl;
	}

	public function getAdvertisements($campaign) {
		$advertisements = array();
		foreach ($campaign->getElementsByTagName('advertisement') as $advertisement) {
			$period = $advertisement->getElementsByTagName('period')->item(0)->nodeValue;
			if (intval($period) == 0) {
				$advertisements[] = $advertisement;
			}
		}
		return $advertisements;
	}

	public function getAdvertisement($campaign) {
	    if (!(gettype($campaign) === 'object' and get_class($campaign) === 'DOMElement')) {
			return null;
		}
		$advertisements = $this->getAdvertisements($campaign);
		usort($advertisements, array($this, '_sortAdvertisement'));
		return $advertisements[0];
	}

	public function getMinPoint($advertisement) {
		$points = $advertisement->getElementsByTagName('point');
		$pointArr = array();
		foreach($points as $point){
			$pointArr[] = intval($point->nodeValue);
		}
		sort($pointArr);
		return $pointArr[0];
	}
	
	private function _sortAdvertisement($a, $b) {
		if ($a->getElementsByTagName('payment')->item(0)->nodeValue == $b->getElementsByTagName('payment')->item(0)->nodeValue) {
			return 0;
		} else {
			return $a->getElementsByTagName('payment')->item(0)->nodeValue > $b->getElementsByTagName('payment')->item(0)->nodeValue ? -1 : 1;
		}
	}

	public function loadCampaign($xmlData=false) {
		$xmlUrl = $this->getCampainUrl();
		$xml = new DomDocument();
		if ($xmlData) {
			$xml->loadXML($xmlData);
			return $xml->getElementsByTagName('campaign');
		}
		$xmlData = file_get_contents($xmlUrl);
		$xml->loadXML($xmlData);
		return $xml->getElementsByTagName('campaign');
	}

	public function createCampaignData($campaign) {
		$campaignData = array();
		$advertisement = $this->getAdvertisement($campaign);
		$campaignIds = $campaign->getElementsByTagname('id');
		$data['campaign_id'] = $campaignIds->item($campaignIds->length - 1)->nodeValue;
		$data['name'] = $campaign->getElementsByTagName('name')->item(0)->nodeValue;
		$budget_is_unlimited = $campaign->getElementsByTagName('budget_is_unlimited')->item(0)->nodeValue;
		$data['budget_is_unlimited'] = $budget_is_unlimited == 'false' ? 0 : 1;
		$data['start_time'] = $campaign->getElementsByTagName('start_time')->item(0)->nodeValue;
		$data['end_time'] = $campaign->getElementsByTagName('end_time')->item(0)->nodeValue;
		$data['subscription_duration'] = $campaign->getElementsByTagName('subscription_duration')->item(0)->nodeValue;
		$data['platform'] = $campaign->getElementsByTagName('platform')->item(0)->nodeValue;
		$data['price'] = $campaign->getElementsByTagName('price')->item(0)->nodeValue;
		$data['market'] = $campaign->getElementsByTagName('market')->item(0)->nodeValue;
		$data['icon'] = $campaign->getElementsByTagName('icon')->item(0)->nodeValue;
		$data['location'] = $campaign->getElementsByTagName('location')->item(0)->nodeValue;
		$data['url'] = $campaign->getElementsByTagName('url')->item(0)->nodeValue;
		$data['remark'] = $campaign->getElementsByTagName('remark')->item(0)->nodeValue;
		$data['detail'] = $campaign->getElementsByTagName('detail')->item(0)->nodeValue;
		$data['advertise_id'] = $advertisement->getElementsByTagName('id')->item(0)->nodeValue;
		$data['advertise_name'] = $advertisement->getElementsByTagName('name')->item(0)->nodeValue;
		$data['advertise_payment'] = $advertisement->getElementsByTagName('payment')->item(0)->nodeValue;
		$data['advertise_period'] = $advertisement->getElementsByTagName('period')->item(0)->nodeValue;
		$data['advertise_point'] = $this->getMinPoint($advertisement);//$advertisement->getElementsByTagName('point')->item(0)->nodeValue;
		$data['advertise_requisite'] = $advertisement->getElementsByTagName('requisite')->item(0)->nodeValue;
		return $data;
	}

	public function getCampaigns($xmlData=false) {
		$campaignDatas = array();
		foreach ($this->loadCampaign($xmlData) as $campaign) {
			$platform = $campaign->getElementsByTagName('platform')->item(0)->nodeValue;
			if (in_array(intval($platform), array(2))) {
				$campaignDatas[] = $this->createCampaignData($campaign);
			}
		}
		return $campaignDatas;
	}

	public function getTopCampaigns($xmlData=false) {
		$campaignData = $this->getCampaigns($xmlData);
		if (empty($campaignData)) {
			return null;
		}
		usort($campaignData, array($this, '_sortByPayment'));
		return array_slice($campaignData, 0, 10);
	}

	private function _sortByPayment($a, $b) {
		if ($a['advertise_payment'] == $b['advertise_payment']) {
			return 0;
		} else {
			return $a['advertise_payment'] > $b['advertise_payment'] ? -1 : 1;
		}
	}
    /*
	public function updateCampaigns() {
		$table = self::$tableName;
		Yii::app()->db->createCommand("delete from $table")->execute();
		foreach($this->getTopCampaigns() as $key=>$data){
			$insertData = array_merge(array('id'=>$key+1), $data);
			DbUtil::insert(Yii::app()->db, $table, $insertData);
		}
	}
	 */
	public function consoleData($campaign) {
		$html = '<ul style="margin-left:20px">'; $advertise_html = '<ul style="margin-left:20px">';
		foreach ($campaign as $key=>$value) {
			if (preg_match('/^advertise/', $key)) {
				$advertise_html .= "<li>$key" . '：' . $value . '</li>';
			} else {
				$html .= "<li>$key" . '：' . $value . '</li>';
			}
		}
		$advertise_html .= '</ul>';
		$html .= '<li>advertisement' . $advertise_html . '</li></ul>';
		return $html;
	}

	public function echoHtml($xmlData=false){
		$html = '';
		$campaigns = $this->getTopCampaigns($xmlData);
		if (empty($campaigns)) {
			return '';
		}
		foreach($campaigns as $campaign) {
			$html .= $this->consoleData($campaign);
			$html .= '<hr>';
		}
		return $html;
	}

	public function start() {
		//$this->updateCampaigns();
		$this->echoHtml();
	}

	public function run($args) {
		if(isset($args[0]) && $args[0] == 'start'){
			$this->start();
        }else{
            return $this->usage();
        }
    }
    
}
?>
