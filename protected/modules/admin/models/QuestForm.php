<?php
class QuestForm extends CFormModel {
    static public $table = 'questEvent';

	public $startTime;
	public $endTime;
    public $questIds;
}
