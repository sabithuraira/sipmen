<?php

class SiteController extends Controller
{
	public $layout='//layouts/column2';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}	

	public function actionIndex()
	{
		$model=new MBs('search');
		$model->unsetAttributes();  // clear any default values

		$model->idProv = '16';
		if(isset($_POST['kab_id']))
			$model->idKab=$_POST['kab_id'];

		if(isset($_POST['kec_id']))
			$model->idKec=$_POST['kec_id'];

		if(isset($_POST['desa_id']))
			$model->idDesa=$_POST['desa_id'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionTerima($id){
		$model_bs = $this->loadBS($id);
		$is_batch_baru = true;

		if($model_bs->nomorbatch!=0)
			$is_batch_baru=false;
		
		$nextBatch = MBatch::model()->getNextBatch($model_bs->idKab);

		if(!$is_batch_baru){
			$nextBatch = array(
				'nomor'	=>$model_bs->nomorbatch,
				'label'	=>$model_bs->nobatch
			);
		}

		if(isset($_POST['jumlah_ruta'])){

			if($is_batch_baru){
				$model = new MBatch;
				$model->idProv = $model_bs->idProv;
				$model->idKab = $model_bs->idKab;
				$model->nobatch = $nextBatch['label'];
				$model->nomorbatch = $nextBatch['nomor'];
				$model->status = '1';
				if($model->save()){
					$model_bs->status_terima = 1;
					$model_bs->jml_terima = $_POST['jumlah_ruta'];
					$model_bs->tgl_terima = date('Y-m-d');
					$model_bs->nobatch = $model->nobatch;
					$model_bs->nomorbatch = $model->nomorbatch;
					$model_bs->save(false);

					for($i=0;$i<$_POST['jumlah_ruta'];++$i){
						$model_ruta = new MRuta;
						$model_ruta->idProv = $model->idProv;
						$model_ruta->idKab	= $model->idKab;
						$model_ruta->nobatch = $model->nobatch;
						$model_ruta->noruta = $this->numberTo3String($i+1);
						if($_POST['nama'.$i]=='')
							$model_ruta->namakrt = 'NN';
						else
							$model_ruta->namakrt = $_POST['nama'.$i];

						$model_ruta->status = '1';
						$model_ruta->ket_status = '';
						$model_ruta->save();
					}
				}

				$this->redirect(array('site/index'));
			}
			else{
				$selisih = $model_bs->jml_terima - $_POST['jumlah_ruta'];
				$model_bs->status_terima = 1;
				$model_bs->jml_terima = $_POST['jumlah_ruta'];
				$model_bs->tgl_terima = date('Y-m-d');
				$model_bs->save(false);

				if($selisih<0){
					for($i=$model_bs->jml_terima;$i<=($model_bs->jml_terima - $selisih);++$i){
						$existing_ruta = MRuta::model()->findByAttributes(array(
							'nobatch'	=>$nextBatch['label'],
							'noruta'	=>$this->numberTo3String($i)
						));

						if($existing_ruta!=null)
							$existing_ruta->delete();
					}
				}

				for($i=0;$i<$_POST['jumlah_ruta'];++$i){
					$existing_ruta = MRuta::model()->findByAttributes(array(
						'nobatch'	=>$nextBatch['label'],
						'noruta'	=>$this->numberTo3String($i+1)
					));
					if($_POST['nama'.$i]=='')
						$existing_ruta->namakrt = 'NN';
					else
						$existing_ruta->namakrt = $_POST['nama'.$i];

					$existing_ruta->save();
				}

				$this->redirect(array('site/index'));
			}
		}

		$this->render('terima', array(
			'model_bs'	=>$model_bs,
			'nextBatch'	=>$nextBatch,
			'is_batch_baru'	=>$is_batch_baru,
		));
	}

	public function numberTo3String($number){
		$label = '';
		if($number < 10)
			$label = '00'.$number;
		else if($number >=10 && $number< 100)
			$label = '0'.$number;
		else if($number>=100 && $number< 1000)
			$label = $number;

		return $label;
	}

	public function actionEdit($id){
		$model_bs = $this->loadBS($id);
		$nextBatch = array(
			'nomor'	=>$model_bs->nomorbatch,
			'label'	=>$model_bs->nobatch
		);

		if(isset($_POST['jumlah_ruta'])){
			$total = 0;
			for($i=0;$i<$model_bs->jml_terima;++$i){

				if(isset($_POST['edit'.$i])){
					///
					$existing_ruta = MRuta::model()->findByAttributes(array(
						'nobatch'	=>$nextBatch['label'],
						'noruta'	=>$this->numberTo3String($i+1)
					));
					$existing_ruta->status = '2';
					$existing_ruta->save();
					$total+=1;
					//
				}
			}

			if($total>0){
				$model_bs->status_edit ='1';
				$model_bs->jml_edit =$total;
				$model_bs->tgl_edit = date('Y-m-d');
				$model_bs->save(false);

				$batch = MBatch::model()->findByAttributes(array(
					'nobatch'	=>$model_bs->nobatch
				));
				if($batch!=null){
					$batch->status = '2';
					$batch->save(false);
				}
			}

			$this->redirect(array('site/index'));
		}

		$this->render('edit', array(
			'model_bs'	=>$model_bs,
			'nextBatch'	=>$nextBatch,
		));
	}

	public function actionGet_list_kec($id)
	{
		$satu='';

		$data=MKec::model()->findAllByAttributes(array('idProv'=>'16', 'idKab'=>$id));
		$data=CHtml::listData($data,'idKec','kodeNama');
	
		$satu.= CHtml::tag('option', array('value'=>0),CHtml::encode('- Semua Kecamatan -'),true);

		foreach($data as $value=>$name)
		{
			$satu.= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}

		echo CJSON::encode(array
		(
			'satu'=>$satu,
		));
		Yii::app()->end();
	}


	public function actionGet_list_desa($id, $id2)
	{
		$satu='';

		$data=MDesa::model()->findAllByAttributes(array('idProv'=>'16', 'idKab'=>$id, 'idKec'=>$id2));
		$data=CHtml::listData($data,'idDesa','kodeNama');

		$satu.= CHtml::tag('option', array('value'=>0),CHtml::encode('- Semua Desa -'),true);
	
		foreach($data as $value=>$name)
		{
			$satu.= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}

		echo CJSON::encode(array
		(
			'satu'=>$satu,
		));
		Yii::app()->end();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout='//layouts/login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


	public function loadBS($id)
	{
		$model=MBs::model()->findByAttributes(array('nks_sutas'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}