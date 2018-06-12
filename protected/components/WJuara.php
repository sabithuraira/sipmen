<?php
Yii::import('zii.widgets.CPortlet');
class WJuara extends CPortlet
{
    public $kab_name="";
    public $title_name="";
    public $color="aqua";

    public $kegiatan = 0;
    public $target = 0;
	public $point = 0;
	public $url = "url";

	public function init()
	{
		parent::init();
	}

	protected function renderContent()
	{
		$this->render('wjuara');
	}
}