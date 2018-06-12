<?php
Yii::import('zii.widgets.CPortlet');
class Star extends CPortlet
{
    public $starNumber=0;
	public function init()
	{
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('star');
	}
}