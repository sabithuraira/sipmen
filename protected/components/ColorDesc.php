<?php
Yii::import('zii.widgets.CPortlet');
class ColorDesc extends CPortlet
{
	public function init()
	{
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('color_desc');
	}
}