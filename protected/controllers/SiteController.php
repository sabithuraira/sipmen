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

		if(isset($_POST['is_terima']))
			$model->status_terima_prov=$_POST['is_terima'];

		$this->render('index',array(
			'model'=>$model,
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
}