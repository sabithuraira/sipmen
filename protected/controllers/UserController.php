<?php

class UserController extends Controller
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
				'actions'=>array('index','view', 'create', 'update'),
				'expression'=> function($user){
					return $user->getLevel()<=2;
				},
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete', 'cpadmin'),
				'expression'=> function($user){
					return $user->getLevel()==1;
				},
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('cp'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCp()
    {
        $data=$this->loadModel(Yii::app()->user->id);

        if(isset($_POST['old'],$_POST['baru1'],$_POST['baru2'])) 
        {
            if($_POST['baru1']!==$_POST['baru2'])
            {
                $data->addError('username','Your New Password Not Match'); 
            }
            else
            {
                if(CPasswordHelper::verifyPassword($_POST['old'], $data->password)) 
                {
                    $dua=$_POST['baru1'];
                    $data->password=CPasswordHelper::hashPassword($_POST['baru1']);
                    if($data->save())
                    {
                        $this->redirect(array('/site'));    
                    }
                }
                else
                {
                    $data->addError('username','Wrong Password');
                }
            }
        }

        $this->render('cp',array(
            'data'=>$data,
        ));
	}
	
	public function actionCpadmin($id)
    {
        $data=$this->loadModel($id);
        if(isset($_POST['baru1'],$_POST['baru2'])) 
        {
            if($_POST['baru1']!==$_POST['baru2'])
            {
                $data->addError('username','Your New Password Not Match'); 
            }
            else
            {
				// $dua=$_POST['baru1'];
				$data->password=CPasswordHelper::hashPassword($_POST['baru1']);
				if($data->save())
				{
					$this->redirect(array('/site'));    
				}
            }
        }

        $this->render('cpadmin',array(
            'data'=>$data,
        ));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if(Yii::app()->user->getLevel()==2){
				$model->type_user=0;
				$model->unit_kerja=Yii::app()->user->getUnitKerja();
			}
			else{
				$model->type_user=$_POST['User']['type_user'];
			}

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if(Yii::app()->user->getLevel()==2){
				$model->type_user=0;
				$model->unit_kerja=Yii::app()->user->getUnitKerja();
			}
			else{
				$model->type_user=$_POST['User']['type_user'];
			}
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
