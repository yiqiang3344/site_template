<?php
/**
 * 开发测试工具类 
 * 
 * 
 */

class DevToolController extends Controller {
	private $player ;
	public $layout='/devTool/layout';
	public $playerId = 0 ;

	public function init() {
		parent::init();
        if( !empty($_GET['isAjax']) ) {
            $this->isAjax = true ;
        }		
	}

	public function actionIndex(){		
		$this->player = new Player($this->playerId);		
		$items = DevTools::getItems();
        $rares = array();
        for($rare = 0; $rare < 4; $rare++){
            $rares[$rare] = Yii::t("AdminModule.DevTool", 'Rare' . $rare);
        }

		$data = array(
            'characterTemplates' => CharacterTemplate::models(),
            'rares' => $rares,
			'equipments'=> DevTools::getEquipments(),
			'personality' => Personality::getAll(),
			'skills'  => DevTools::getSkills(),
		);
        $data = array_merge($data, $items);
		$this->display( 'index',$data );
	}
	
	public function actionTest(){
		$this->display('',serialize(array('a'=>123,'b'=>456)));
	}
	
	public function actionCharacter(){
		$jobId = intval($_GET['jobid']) ;
		$num = intval( $_GET['num'] );
		
		$quality = intval($_GET['elite']);
		if( $quality>1 ) {
			$isShop = true ;
			$isSliver = $quality==3?true:false ;
			$isElite = $quality==2?true:false ;
		}
		else {
			$isElite = $quality==1?true:false;
			$isShop = false ;
			$isSliver = false ;
		}
		
		
		$recruit = new Recruit($this->playerId);
		
		$data = array();
		$uKeys = explode(' ','characterName basicId characterName autoName hpMax defaultAge lastName');
		for( $i=1;$i<=$num;$i++ ) {
			//foreach( Character::getAbilityKeys() as $key ) $data[$i][$key] = rand(0,999);

			$r = $recruit->debugFetchCharacter($jobId,$isElite,$isShop,$isSliver) ;
			extract($r);
			$characterInfo = array();
			foreach( $normal as $k=>$v ) {
				if( !empty($v)&&isset($min[$k])&&isset($max[$k])&&!($v==$min[$k]&&$v==$max[$k]) ) {
					$v .= " (".$min[$k]." - ".$max[$k].")";
				}
				$characterInfo[$k] = $v ;
			} 

			foreach( $uKeys as $k ) unset($characterInfo[$k]);

			$data[$i] = $characterInfo ;
		}
		$this->display('',$this->dealResult($data));
	}
	
	public function actionSendCharater(){
		try {
			$playerId = intval($_GET['playerid']);
			$templateId = intval($_GET['templateid']) ;
			$rare= intval($_GET['rare']);
			$level = intval($_GET['level']);
			$personalityId = intval($_GET['personalityId']);
			$skill1 = intval($_GET['skill1']);
			$skill2 = intval($_GET['skill2']);
			$skill3 = intval($_GET['skill3']);
			$sLevel1 = intval($_GET['slv1']);
			$sLevel2 = intval($_GET['slv2']);
			$sLevel3 = intval($_GET['slv3']);
			$skills = array($skill1, $skill2, $skill3);
            $template = CharacterTemplate::factory($templateId);
            if((isset($template->rare) && $rare != $template->rare) or (!isset($template->rare) and $rare == 3)){
                $this->error(Yii::t('AdminModule.DevTool', 'Rare Error'));
            }
			if (max(array_count_values($skills)) > 1) {			    
			    $this->error('发送失败！请输入不同的技能参数。');
			}
			$skills = array($skill1=>$sLevel1, $skill2=>$sLevel2, $skill3=>$sLevel3);
			foreach ($skills as $skillId=>$sLevel) {
				if ($skillId > 0) {
					$skill = Skill::factory($skillId);
					if (!$skill->canJobUse($template->jobId)) {
						throw new CException('技能：' . $skill->getSkillName() . '错误。');
					}
				}
			}
            $origin = MortalCharacter::ORIGIN_ADMIN;
			$player = Player::factory($playerId);
			$character = $player->generateCharacter($templateId, $origin, $rare, $level, array(), array('personalityId' => $personalityId));
			foreach ($skills as $skillId=>$skillLevel) {
				if ($skillId > 0) {
					$skillInfo = array('playerId'=>$playerId, 'characterId'=>$character->characterId, 'skillId'=>$skillId, 'level'=>$skillLevel);
					CharacterSkill::create($skillInfo);
				}
			}
			$this->success('成功发送角色给Player['.$playerId.']');
		}
		catch (CException $e){
			$this->error('发送失败！'.$e->getMessage());
		}
	}
	
	public function actionEquip(){
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $playerId = intval($_GET['playerid']);
            $startId = intval($_GET['startId']);
            $endId = intval($_GET['endId']);
            $num = intval($_GET['num']);
            $lv = intval($_GET['elv']);
            $equipmentId = intval($_GET['itemid']);
            $color = intval($_GET['color']);
            if ($playerId && $num && $color) {
                $equipmentIds = array();
                if($equipmentId){
                    $equipmentIds = array($equipmentId);
                }elseif($startId and $endId){
                    $equipmentIds = range($startId, $endId);
                }
                DevTools::sendEquipments($equipmentIds, $num, $playerId, $lv, $color);
                $transaction->commit();
                $this->success('装备发送成功！');
            } else {
                $this->error('请输入正确的参数');
            }
        }catch(Exception $e){
            $transaction->rollback();
			$this->error('发送失败！'.$e->getMessage());
        }
	}

	public function actionItem(){
		try {
			$playerId = intval($_GET['playerid']);
			$num = intval($_GET['num']);
			$itemId = intval($_GET['itemid']) ;
			$type = intval($_GET['type']);
			DevTools::sendItems($playerId, $itemId, $num, $type);
			
			$this->success('物品发送成功！');
		}
		catch (CException $e){
			$this->error('发送失败！'.$e->getMessage());
		}
	}	
	public function actionMoney(){
		try {
			$playerId = intval($_GET['playerid']);
			$value = intval($_GET['money']) ;
			$money = new PlayerMoney($playerId);
			$money->send($value,'dev tools send');
			
			$this->success('用户['.$playerId.']获得['.$value.']systemSp <br />当前SP总和<font color=red>『'.$money->getMoney().'』</font>');
		}
		catch (CException $e){
			$this->error('发送失败！'.$e->getMessage());
		}
	}
	public function actionGold() {
		try {
			$playerId = intval($_GET['playerid']);
			$value = intval($_GET['gold']) ;
			$player = new Player($playerId);
			$player->addGold($value);
			
			$this->success('用户['.$playerId.']获得金币['.$value.'] <br />当前金币总共<font color=red>『'.$player->getGold().'』</font>');
		}
		catch (CException $e){
			$this->error('发送失败！'.$e->getMessage());
		}
	}

	public function actionSendFP() {
		try {
			$playerId = intval($_GET['playerid']);
			$friendPoint = intval($_GET['fp']) ;
			$player=Player::factory($playerId);
			$originFP = $player->friendPoint;
			$player->addFriendPoint($friendPoint, 'system send');
			$currentFP = $player->friendPoint;
			$this->success('用户['.$playerId.']原有friendPoint['.$originFP.'],现获得friendPoint['.($currentFP-$originFP).'],当前friendPoint总共为['.$currentFP.']');
		}
		catch (CException $e){
			$this->error('发送失败！'.$e->getMessage());
		}
	}

	public function actionRate(){
		$action = $_GET['do'];
		$townId = intval($_GET['townid']) ;
		$data = array() ;
		$recruit = new Recruit($this->playerId);
		
		switch ($action) {
			case 'attribute':
				$result = $recruit->getAttributeRate($townId);
				$sum = array_sum($result);
				foreach( $result as $i=>$val ){
					$data[Yii::t('Character','Attribute_name_'.$i)] = sprintf('%0.2f',$val/$sum*100).'%';
				}
				break;
			
			case 'job': 
				$result = $recruit->getTownJobRate($townId);
				$sum = array_sum($result);
				foreach( $result as $i=>$val ){
					$data[Yii::t('Character','Job_'.$i)] = sprintf('%0.2f',$val/$sum*100).'%';
				}
								
				break ;
			default:
				$data = array() ;
			break;
		}
		
		$this->display('',$this->dealResult($data));
	}
	
	
	public function dealResult($data){
		return "<pre>".print_r($data,true)."\n</pre>";
	}
}

