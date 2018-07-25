<?php

Yii::import("application.vendor.phpexcel.*");
require_once("PHPExcel/IOFactory.php");

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FileForm extends CFormModel
{
    public $filename;
    public $listname;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('filename', 'file', 'types'=>'xlsx'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'filename'=>'File',
        );
    }

      // get all sheet in excel file
    public function getSheet($name)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $listsheet=$objReader->listWorksheetNames($inputFileName);

        $result=array();
        foreach ($listsheet as $key => $value) {
            $result[]=array('id'=>$key,'label'=>$value);
        }
        return $result;
    }


    /// check name of sheet index
    // name = name of excel file
    // id = index excel file that want to know the sheet name
    public function getSheetnameByIndex($name,$id)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $listsheet=$objReader->listWorksheetNames($inputFileName);

        return $listsheet[$id];
    }

    public function importSutas($name,$sheet,$id, $kab)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null,true,true,true);

        $sheetname=$this->getSheetnameByIndex($name,$sheet);

        $model_bs=MBs::model()->findByAttributes(array('nks_sutas'=>$id, 'idKab'=> $kab));
        $is_batch_baru = true;
        $jumlah_ruta = 0;
        $is_validate = true;

        $all_number = array();
        $all_name = array();
               
        if($model_bs!=null){
            if($model_bs->nomorbatch!=0)
                $is_batch_baru=false;
            
            $nextBatch = MBatch::model()->getNextBatch($model_bs->idKab);
    
            if(!$is_batch_baru){
                $nextBatch = array(
                    'nomor'	=>$model_bs->nomorbatch,
                    'label'	=>$model_bs->nobatch
                );
            }
        }

        foreach ($sheetData as $key => $value)
        {    
            if($key>1)
            {
                if($key==2){
                    if(isset($value['B']) && strlen($value['B'])>0)
                    {
                        // if($is_batch_baru){
                            $jumlah_ruta = $value['B'];
                        // }
                    }
                    else{
                        $is_validate = false;
                    }
                }
                else if($key>3 && $key<=(3+$jumlah_ruta)){
                    $all_number[] = $value['A'];
                    $all_name[] = $value['B'];
                }
            }   
        }

        for($i=1;$i<=$jumlah_ruta;++$i){
            if(!in_array($i, $all_number))
            {
                $is_validate = false;
            }
        }

        if($is_validate){
            if($is_batch_baru){
                $model = new MBatch;
                $model->idProv = $model_bs->idProv;
                $model->idKab = $model_bs->idKab;
                $model->nobatch = $nextBatch['label'];
                $model->nomorbatch = $nextBatch['nomor'];
                $model->status = '1';

                
                if($model->save()){
                    $model_bs->status_terima = 1;
                    $model_bs->jml_terima = $jumlah_ruta;
                    $model_bs->tgl_terima = date('Y-m-d');
                    $model_bs->nobatch = $nextBatch['label'];
                    $model_bs->nomorbatch = $nextBatch['nomor'];
                    $model_bs->save(false);
                }
            }
            else{
                $model_bs->status_terima = 1;
                $model_bs->jml_terima = $jumlah_ruta;
                $model_bs->tgl_terima = date('Y-m-d');
                $model_bs->save(false);
            }

            for($i=0;$i<$jumlah_ruta;++$i){
                $model_ruta = new MRuta;
                $model_ruta->idProv = $model_bs->idProv;
                $model_ruta->idKab	= $model_bs->idKab;
                $model_ruta->nobatch = $nextBatch['label'];
                $model_ruta->noruta = $this->numberTo3String($all_number[$i]);
                if($all_name[$i]=='')
                    $model_ruta->namakrt = 'NN';
                else
                    $model_ruta->namakrt = $all_name[$i];

                $model_ruta->status = '1';
                $model_ruta->ket_status = '';
                $model_ruta->save();
            }
        }

        unlink(Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx");
        Yii::app()->getController()->redirect(array('/site/index'));

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
}