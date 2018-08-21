<?php

class SipmenController extends Controller
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
				'actions'=>array('terima','edit', 'kirim', 'import', 'selecttab', 'delete_ruta'),
				'expression'=> function($user){
					return $user->getLevel()<=2;
				},
			),

			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('reset'),
				'expression'=> function($user){
					return $user->getLevel()==1;
				},
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('terimaprov'),
				'expression'=> function($user){
					return ($user->getLevel()==1 || $user->getLevel()==3);
				},
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionDelete_ruta($batch, $kab, $noruta)
	{
		$satu='false';

		$data = MRuta::model()->findByAttributes(array(
			'idKab'		=>$kab,
			'nobatch'	=>$batch,
			'noruta'	=>$this->numberTo3String($noruta)//$noruta
		));

		$model_bs = MBs::model()->findByAttributes(array(
			'idKab'	=>$kab,
			'nobatch'	=>$batch
		));

		if($model_bs!=null){
			$model_bs->updateJumlah();
		}

		if($data!=null){
			$data->delete();
			$satu = 'true';
		}

		echo CJSON::encode(array
		(
			'satu'=>$satu,
		));
		Yii::app()->end();
	}
	
	public function actionImport($id, $kab)
	{
		$model_bs = $this->loadBS($id, $kab);

		$is_batch_baru = true;
		
		if($model_bs->nomorbatch!=0)
			$is_batch_baru=false;

		$model=new FileForm;

		if(isset($_POST['FileForm']))
		{
			$model->attributes=$_POST['FileForm'];
			
			if($_FILES)
			{
				$cUploadedFile=CUploadedFile::getInstance($model,'filename');
				if($cUploadedFile)
				{
					$naname=sha1(uniqid(mt_rand(), true));
					$fileName=$naname.'.'.$cUploadedFile->extensionName;
					if($cUploadedFile->saveAs(Yii::app()->basePath.'/../upload/temp/' . $fileName))
					{
						$this->redirect(array('selecttab','name'=>$naname,'id'=>$id, 'kab'=>$kab));	
					}
				}
			}
			
		}

		$this->render('import',array(
			'model'=>$model,
			'id'=>$id,
			'model_bs'	=>$model_bs,
			'is_batch_baru'	=>$is_batch_baru
		));
	}

	public function actionSelecttab($name,$id, $kab)
    {
		$model_bs = $this->loadBS($id, $kab);

		$is_batch_baru = true;
		
		if($model_bs->nomorbatch!=0)
			$is_batch_baru=false;

        $model=new FileForm;
        if(isset($_POST['listname']))
        {
            $model->importSutas($name,$_POST['listname'],$id, $kab);
            // $model->importPaguSatker($name,$_POST['listname']);
        }

        $this->render('select',array(
            'naname'=>$name,
			'model' =>$model,
			'model_bs'	=>$model_bs,
			'is_batch_baru'	=>$is_batch_baru
        ));
	}
	
	public function actionReset($id, $kab){
		MBs::model()->reset($id,$kab);
		$this->redirect(array('sipmen/terima','id'=>$id, 'kab'=>$kab));
	}
    

	public function actionTerima($id, $kab){
		$model_bs = $this->loadBS($id, $kab);
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

		if(isset($_POST['jumlah_ruta']) && $_POST['jumlah_ruta']>0){

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
						$model_ruta->noruta = $this->numberTo3String($_POST['noruta'.$i]);
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

					if($existing_ruta==null){
						$existing_ruta = new MRuta;

						$existing_ruta->idProv = $model_bs->idProv;
						$existing_ruta->idKab	= $model_bs->idKab;
						$existing_ruta->nobatch = $nextBatch['label'];
						$existing_ruta->noruta = $this->numberTo3String($_POST['noruta'.$i]);

						$existing_ruta->status = '1';
						$existing_ruta->ket_status = '';
					}

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

	public function actionEdit($id, $kab){
		$model_bs = $this->loadBS($id, $kab);
		$nextBatch = array(
			'nomor'	=>$model_bs->nomorbatch,
			'label'	=>$model_bs->nobatch
		);

		if(isset($_POST['jumlah_ruta'])){
			$total = 0;
			$total_drop = 0;
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

				if($_POST['is_drop'.$i] == 1){
					///
					$existing_ruta = MRuta::model()->findByAttributes(array(
						'nobatch'	=>$nextBatch['label'],
						'noruta'	=>$this->numberTo3String($i+1)
					));
					$existing_ruta->status = '9';
					$existing_ruta->ket_status = $_POST['drop'.$i];
					$existing_ruta->save();
					$total_drop+=1;
					//
				}
				
			}

			if($total>0){
				$model_bs->status_edit ='1';
				$model_bs->jml_edit =$total;
				$model_bs->jml_drop = $total_drop;
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

	public function actionKirim($id, $kab){
		$model_bs = $this->loadBS($id, $kab);
		$nextBatch = array(
			'nomor'	=>$model_bs->nomorbatch,
			'label'	=>$model_bs->nobatch
		);

		if(isset($_POST['jumlah_ruta'])){
			$total = 0;

			$all_ruta_edit = MRuta::model()->findAllByAttributes(
				array(
					'nobatch'	=>$nextBatch['label'],
				),
				array(
					'condition' =>'status >=2 && status!=9',
				)
			);
			
			foreach($all_ruta_edit as $key=>$value){
				if(isset($_POST['kirim'.$value['noruta']])){
					///
					$value->status = '3';
					$value->save();
					$total+=1;
					//
				}
			}

			if($total>0){
				$model_bs->status_kirim ='1';
				$model_bs->jml_kirim =$total;
				// $model_bs->nmr_kirim =$total;
				$model_bs->tgl_kirim = date('Y-m-d');
				$model_bs->save(false);

				$batch = MBatch::model()->findByAttributes(array(
					'nobatch'	=>$model_bs->nobatch
				));
				if($batch!=null){
					$batch->status = '3';
					$batch->save(false);
				}
			}

			$this->redirect(array('site/index'));
		}

		$this->render('kirim', array(
			'model_bs'	=>$model_bs,
			'nextBatch'	=>$nextBatch,
		));
	}


	public function actionTerimaprov($id, $kab){
		$model_bs = $this->loadBS($id, $kab);
		$nextBatch = array(
			'nomor'	=>$model_bs->nomorbatch,
			'label'	=>$model_bs->nobatch
		);

		if(isset($_POST['jumlah_ruta'])){
			$total = 0;

			$all_ruta_edit = MRuta::model()->findAllByAttributes(
				array(
					'nobatch'	=>$nextBatch['label'],
				),
				array(
					'condition' =>'status >=3 && status!=9',
				)
			);
			
			foreach($all_ruta_edit as $key=>$value){
				if(isset($_POST['prov'.$value['noruta']])){
					$value->status = '4';
					$value->save();
					$total+=1;
				}
			}

			if($total>0){
				$model_bs->status_terima_prov ='1';
				$model_bs->jml_terima_prov =$total;
				$model_bs->tgl_terima_prov = date('Y-m-d');
				$model_bs->terima_by = Yii::app()->user->id;
				$model_bs->save(false);

				$batch = MBatch::model()->findByAttributes(array(
					'nobatch'	=>$model_bs->nobatch
				));
				if($batch!=null){
					$batch->status = '4';
					$batch->save(false);
				}
			}

			$this->redirect(array('site/index'));
		}

		$this->render('terimaprov', array(
			'model_bs'	=>$model_bs,
			'nextBatch'	=>$nextBatch,
		));
    }
    


	public function loadBS($id, $kab)
	{
		$model=MBs::model()->findByAttributes(array('nks_sutas'=>$id, 'idKab'=> $kab));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
