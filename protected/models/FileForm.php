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

    public function importPagu($name,$sheet)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null,true,true,true);

        //create sheet name in table function if not exist
        
        $sheetname=$this->getSheetnameByIndex($name,$sheet);

        foreach ($sheetData as $key => $value)
        {    
            if($key>1)
            {       
               if(isset($value['H']) && strlen($value['H'])>0 && isset($value['J']) && strlen($value['J'])>0)
                {
                    $model=new Pagu;
                    if(strlen(trim($value['H']))==1)
                    {
                        //$model->m_induk=$value['H'];
                    }
                    else
                    {
                        $data_output=new MOutput;
                        $output_check=MOutput::model()->findByAttributes(array('no'=>trim($value['H'])));
                        if($output_check!=null){
                            $data_output=$output_check;
                        }
                        else{
                            $data_output->no=trim($value['H']);
                            $data_output->label=trim($value['J']);
                            $data_output->m_induk=substr(trim($value['H']), 0,1);
                            if(strlen(trim($value['H']))>4)
                                $data_output->parent=substr(trim($value['H']), 0,4);

                            $data_output->save();
                        }

                        $model->m_output=$data_output->id;

                        if(strlen(trim($value['L']))==0)
                            $model->unit_kerja=1;
                        else if(trim($value['L'])=='IPDS')
                            $model->unit_kerja=2;
                        else if(trim($value['L'])=='SOSIAL')
                            $model->unit_kerja=5;
                        else if(trim($value['L'])=='PRODUKSI')
                            $model->unit_kerja=13;
                        else if(trim($value['L'])=='DISTRIBUSI')
                            $model->unit_kerja=38;
                        else if(trim($value['L'])=='NERACA')
                            $model->unit_kerja=34;
                        else if(trim($value['L'])=='TATA USAHA')
                            $model->unit_kerja=28;

                        $model->jumlah=(strlen(trim($value['K']))==0) ? 0 : str_replace(",", "",$value['K'])*1000000;
                        $model->tahun=date('Y');
                        $model->save();
                    }

                    //print_r($model->getErrors());die();
                }
            }   
        }
        //print_r($sheetData);
        unlink(Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx");
        Yii::app()->getController()->redirect(array('/anggaran/index'));

    }


    public function importPagu2($name,$sheet)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null,true,true,true);

        //create sheet name in table function if not exist
        
        $sheetname=$this->getSheetnameByIndex($name,$sheet);

        $current_parent;

        foreach ($sheetData as $key => $value)
        {    
            if($key>4)
            {       
                if(isset($value['A']) && strlen($value['A'])>0 && isset($value['B']) && strlen($value['B'])>0)
                {
                    $model=new Pagu;
                    if(strlen(trim($value['A']))==1)
                    {
                        //$model->m_induk=$value['H'];
                    }
                    else
                    {
                        $data_output=new MOutput;
                        $output_check=MOutput::model()->findByAttributes(array('no'=>trim($value['A'])));
                        if($output_check!=null){
                            $data_output=$output_check;
                        }
                        else{
                            $data_output->no=trim($value['A']);
                            $data_output->label=trim($value['B']);
                            $data_output->m_induk=substr(trim($value['A']), 0,1);
                            $data_output->save();
                        }

                        $model->m_output=$data_output->id;
                        $current_parent=$data_output->no;

                        $model->unit_kerja=1;
                        $model->jumlah=(strlen(trim($value['G']))==0) ? 0 : str_replace(",", "",$value['G']);
                        $model->revisi=(strlen(trim($value['H']))==0) ? 0 : str_replace(",", "",$value['H']);
                        $model->tw1=(strlen(trim($value['I']))==0) ? 0 : str_replace(",", "",$value['I']);
                        $model->tw2=(strlen(trim($value['J']))==0) ? 0 : str_replace(",", "",$value['J']);
                        $model->tw3=(strlen(trim($value['K']))==0) ? 0 : str_replace(",", "",$value['K']);
                        $model->tw4=(strlen(trim($value['L']))==0) ? 0 : str_replace(",", "",$value['L']);

                        $model->tahun=date('Y');
                        $model->save();
                    }
                }
                else{
                    if(isset($value['C']) && strlen($value['C'])>0 && isset($value['D']) && strlen($value['D'])>0)
                    {

                        $model=new Pagu;
                        if(strlen(trim($value['C']))==1)
                        {
                            //$model->m_induk=$value['H'];
                        }
                        else
                        {
                            $data_output=new MOutput;
                            $output_check=MOutput::model()->findByAttributes(array('no'=>$current_parent.trim($value['C'])));
                            if($output_check!=null){
                                $data_output=$output_check;
                            }
                            else{
                                $data_output->no=$current_parent.trim($value['C']);
                                $data_output->label=trim($value['D']);
                                $data_output->m_induk=substr(trim($current_parent), 0,1);
                                $data_output->parent=$current_parent;
                                $data_output->save();
                            }

                            $model->m_output=$data_output->id;

                            $model->unit_kerja=1;
                            $model->jumlah=(strlen(trim($value['G']))==0) ? 0 : str_replace(",", "",$value['G']);
                            $model->revisi=(strlen(trim($value['H']))==0) ? 0 : str_replace(",", "",$value['H']);
                            $model->tw1=(strlen(trim($value['I']))==0) ? 0 : str_replace(",", "",$value['I']);
                            $model->tw2=(strlen(trim($value['J']))==0) ? 0 : str_replace(",", "",$value['J']);
                            $model->tw3=(strlen(trim($value['K']))==0) ? 0 : str_replace(",", "",$value['K']);
                            $model->tw4=(strlen(trim($value['L']))==0) ? 0 : str_replace(",", "",$value['L']);

                            $model->tahun=date('Y');
                            $model->save();
                        }
                    }
                }
            }   
        }
        //print_r($sheetData);
        unlink(Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx");
        Yii::app()->getController()->redirect(array('/anggaran/index'));

    }

    public function importPaguSatker($name,$sheet)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null,true,true,true);

        //create sheet name in table function if not exist
        
        $sheetname=$this->getSheetnameByIndex($name,$sheet);

        foreach ($sheetData as $key => $value)
        {    
            if($key>1)
            {       
               if(isset($value['A']) && strlen(trim($value['A']))>2 && isset($value['B']) && strlen($value['B'])>0)
                {
                    $data_output=new MOutput;
                    $output_check=MOutput::model()->findByAttributes(array('no'=>trim($value['A'])));
                    if($output_check!=null){
                        $data_output=$output_check;
                    }
                    else{
                        $data_output->no=trim($value['A']);
                        $data_output->label=trim($value['B']);
                        $data_output->m_induk=substr(trim($value['A']), 0,1);
                        $data_output->save();
                    }

                    ////////////
                    foreach(range('F','T') as $i) {

                        $model=new Pagu;
                        $model->m_output=$data_output->id;
                        $kodekab='1601';

                        if($i=='G')
                            $kodekab='1602';
                        else if($i=='H')
                            $kodekab='1603';
                        else if($i=='I')
                            $kodekab='1604';
                        else if($i=='J')
                            $kodekab='1605';
                        else if($i=='K')
                            $kodekab='1606';
                        else if($i=='L')
                            $kodekab='1607';
                        else if($i=='M')
                            $kodekab='1608';
                        else if($i=='N')
                            $kodekab='1609';
                        else if($i=='O')
                            $kodekab='1610';
                        else if($i=='P')
                            $kodekab='1611';
                        else if($i=='Q')
                            $kodekab='1671';
                        else if($i=='R')
                            $kodekab='1672';
                        else if($i=='S')
                            $kodekab='1673';
                        else if($i=='T')
                            $kodekab='1674';

                        $model->unit_kerja=UnitKerja::model()->findByAttributes(array('code'=>$kodekab))->id;
                        $model->jumlah=(strlen(trim($value[$i]))==0) ? 0 : str_replace(",", "",$value[$i])*1000000;
                        $model->tahun=date('Y');
                        $model->save();
                    }

                    //print_r($model->getErrors());die();
                }
            }   
        }
        //print_r($sheetData);
        unlink(Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx");
        Yii::app()->getController()->redirect(array('/anggaran/satker'));

    }

    public function importKab($name,$sheet,$kab)
    {
        $inputFileType = 'Excel2007';
        $inputFileName = Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx";
       
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null,true,true,true);

        //create sheet name in table function if not exist
        
        $sheetname=$this->getSheetnameByIndex($name,$sheet);

        foreach ($sheetData as $key => $value)
        {    
            if($key>4 && $key<8)
            {       
               $induk=1;
               if($key==5)
                    $induk=2;
                else if($key==6)
                    $induk=3;

                foreach(range('C','N') as $ikey=>$ivalue) {
                    $model              =new PaguSatker;
                    $model->m_induk     =$induk;
                    $model->unit_kerja  =$kab;
                    $model->jumlah      =$value[$ivalue];
                    $model->bulan       =($ikey+1);
                    $model->tahun       =date('Y');
                    $model->save();

                }
            }   
        }
        //print_r($sheetData);
        unlink(Yii::getPathOfAlias('webroot')."/upload/temp/".$name.".xlsx");
        Yii::app()->getController()->redirect(array('/anggaran/kab','id'=>$kab));

    }

}