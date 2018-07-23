<?php

class ReportController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','user', 'cetak', 'get_list_cetak'),
				'expression'=> function($user){
					return $user->getLevel()<=3;
				},
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('operator'),
				'expression'=> function($user){
					return ($user->getLevel()==1 || $user->getLevel()==3);
				},
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionGet_list_cetak()
	{
		$model = new Mbs;

		if(isset($_POST['kab_id']))
			$model->idKab=$_POST['kab_id'];

		if(isset($_POST['kec_id']))
			$model->idKec=$_POST['kec_id'];

		if(isset($_POST['desa_id']))
			$model->idDesa=$_POST['desa_id'];

		$data = $model->getCetak();

		echo CJSON::encode(array
		(
			'hasil'=>$data,
		));
		Yii::app()->end();
	}

	public function actionCetak(){
		$model=new MBs('search');
		$model->unsetAttributes();  // clear any default values

		$model->idProv = '16';
		if(isset($_POST['kab_id']))
			$model->idKab=$_POST['kab_id'];

		if(isset($_POST['kec_id']))
			$model->idKec=$_POST['kec_id'];

		if(isset($_POST['desa_id']))
			$model->idDesa=$_POST['desa_id'];

		$model->status_terima_prov = 1;
		$model->kirim_ipds = 0;

		$this->render('cetak',array(
			'model'=>$model,
		));
	}
	
	public function actionUser()
	{
		$data = MBs::model()->getRekapOp();

		$model=new MBs('search');
		$model->unsetAttributes();  // clear any default values

		$model->idProv = '16';
		if(isset($_POST['kab_id']))
		{
			$model->idKab=$_POST['kab_id'];
			$data = MBs::model()->getRekapOp($model->idKab);

			if(isset($_POST['kec_id'])){
				$model->idKec=$_POST['kec_id'];
				$data = MBs::model()->getRekapOp($model->idKab, $model->idKec);

				if(isset($_POST['desa_id'])){
					$model->idDesa=$_POST['desa_id'];
					$data = MBs::model()->getRekapOp($model->idKab, $model->idKec, $model->idDesa);
				}
			}
		}

		$this->render('user', array(
			'data'	=>$data,
			'model'=>$model,
		));
    }

	public function actionIndex()
	{
		$data = MBs::model()->getRekap();

		$model=new MBs('search');
		$model->unsetAttributes();  // clear any default values

		$model->idProv = '16';
		if(isset($_POST['kab_id']))
		{
			$model->idKab=$_POST['kab_id'];
			$data = MBs::model()->getRekap($model->idKab);

			if(isset($_POST['kec_id'])){
				$model->idKec=$_POST['kec_id'];
				$data = MBs::model()->getRekap($model->idKab, $model->idKec);

				if(isset($_POST['desa_id'])){
					$model->idDesa=$_POST['desa_id'];
					$data = MBs::model()->getRekap($model->idKab, $model->idKec, $model->idDesa);
				}
			}
		}

		$this->render('index', array(
			'data'	=>$data,
			'model'=>$model,
		));
    }
}
