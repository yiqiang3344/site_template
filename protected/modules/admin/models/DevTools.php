<?php
class DevTools {

	static public function getEquipments() {
	    $command = Yii::app()->db->createCommand('select * from equipmentBase');
        $equipments = $command->queryAll();
        $equipments = Util::changeArrayToHashByKey($equipments, 'equipmentBaseId');
        array_walk($equipments, function(&$equipment){
            $equipment['equipmentName'] = $equipment['equipmentBaseId'] . "、" . strip_tags(Yii::t("Item", $equipment['baseName']));
        });
		return $equipments;
	}

	static public function getItems() {
        $uitems = Util::loadconfig('uItem');
        $citems = Util::loadconfig('cItem');
        $eitems = Util::loadconfig('eItem');
        $items = compact("uitems", "citems", "eitems");
		return $items;
	}

	static public function getSkills() {
	    $sql = 'select skillName from skill';
		$command = Yii::app()->db->createCommand($sql);
		$skills = $command->queryColumn();
		return $skills;
	} // end func

	static public function sendEquipments($equipmentIds, $num, $playerId, $lv, $color) {
        $equipmentIds = array_keys(array_count_values($equipmentIds));
        $equipmentIds = array_intersect($equipmentIds, array_keys(self::getEquipments()));
        if(empty($equipmentIds)){
            throw new Exception('请输入正确的参数');
        }
        $tBag = Yii::app()->objectLoader->load('TemporaryBag', $playerId);
        $bases = array();
        foreach($equipmentIds as $baseId){
            array_push($bases, EquipmentBase::factory($baseId));
        }
        foreach($bases as $base){
            if($base->maxLv < $lv){
                throw new SException('输入等级太大');
            }
            $tEquipment = $base->createEquipment($color);
            if($tEquipment->equipType == Equipment::EQUIP_TYPE_PVE){
                $eBag = Yii::app()->objectLoader->load('EquipmentBag', $playerId);
            }else{
                $eBag = Yii::app()->objectLoader->load('PvpEquipmentBag', $playerId);
            }
            $tEquipments = array_fill(0, $num, $tEquipment);
            $bagSpace = $eBag->getBagLimit() - $eBag->getItemNum();
            if($bagSpace >= $num){
                $itemIds = $eBag->addEquipments($tEquipments, 4);
            }else{
                $itemIds = $eBag->addEquipments(array_splice($tEquipments, 0, $bagSpace), 4);
                $itemIds += $tBag->addEquipments($tEquipments, 4);
            }
            $items = array();
            foreach($itemIds as $itemId){
                array_push($items, Item::factory($itemId));
            }
            foreach($items as $item){
                $item->object->strongToLevel($lv);
            }
        }
	}

	static public function sendItems($playerId, $objectId, $num, $type) {
		$uBag = Yii::app()->objectLoader->load('UItemBag', $playerId);
		$objectIds = array();
		for ($i=0;$i<$num;$i++) {
		    $objectIds[$i] = $objectId;
		}
		if ($uBag->getItemNum() + $num <= $uBag->getBagLimit()) {//$uBag->getItemNum() + $num <= $uBag->getBagLimit()
		    $itemIds = $uBag->addItems($objectIds, $type, 4);
		} else {
			$tBag = Yii::app()->objectLoader->load('TemporaryBag', $playerId);
			$itemIds = $tBag->addItems($objectIds, $type, 4);
		}
	}
}
?>
