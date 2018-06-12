<?php
class HelpMe
{
    public static function HrUser($id)
    {
        $model=UserAdm::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return CHtml::link($model->name,array('user/view','id'=>$id));
    }

    public static function HrDate($date='0000-00-00')
    {
        //return date('D, d M Y H:i',strtotime($date));
        return date('D, d M Y',strtotime($date));
    }


    public static function getYearForFilter()
    {
        $arr=array();
        for($i=2015;$i<=date('Y');++$i)
        {
            $arr[]=array('id'=>$i);
        }

        return CHtml::listData($arr,'id','id');
    }


    public static function getMonthList()
    {
        $arr=array();
        $arr[]=array('id'=>'01','label'=>'Januari');
        $arr[]=array('id'=>'02','label'=>'Februari');
        $arr[]=array('id'=>'03','label'=>'Maret');
        $arr[]=array('id'=>'04','label'=>'April');
        $arr[]=array('id'=>'05','label'=>'Mei');
        $arr[]=array('id'=>'06','label'=>'Juni');
        $arr[]=array('id'=>'07','label'=>'Juli');
        $arr[]=array('id'=>'08','label'=>'Agustus');
        $arr[]=array('id'=>'09','label'=>'September');
        $arr[]=array('id'=>10,'label'=>'Oktober');
        $arr[]=array('id'=>11,'label'=>'November');
        $arr[]=array('id'=>12,'label'=>'Desember');

        return CHtml::listData($arr,'id','label');
    }

    public static function getMonthList_singleNumber()
    {
        $arr=array();
        $arr[]=array('id'=>1,'label'=>'Januari', 'short_lbl'=>'Jan');
        $arr[]=array('id'=>2,'label'=>'Februari', 'short_lbl'=>'Feb');
        $arr[]=array('id'=>3,'label'=>'Maret', 'short_lbl'=>'Mar');
        $arr[]=array('id'=>4,'label'=>'April', 'short_lbl'=>'Apr');
        $arr[]=array('id'=>5,'label'=>'Mei', 'short_lbl'=>'Mei');
        $arr[]=array('id'=>6,'label'=>'Juni', 'short_lbl'=>'Jun');
        $arr[]=array('id'=>7,'label'=>'Juli', 'short_lbl'=>'Jul');
        $arr[]=array('id'=>8,'label'=>'Agustus', 'short_lbl'=>'Ags');
        $arr[]=array('id'=>9,'label'=>'September', 'short_lbl'=>'Sep');
        $arr[]=array('id'=>10,'label'=>'Oktober', 'short_lbl'=>'Okt');
        $arr[]=array('id'=>11,'label'=>'November', 'short_lbl'=>'Nov');
        $arr[]=array('id'=>12,'label'=>'Desember', 'short_lbl'=>'Des');

        return CHtml::listData($arr,'id','label');
    }
    
    //return list of user type in CHtml::listData for dropdownlist
    public static function getTypeUser()
    {
        $arr=array();
        $arr[]=array('id'=>0,'label'=>'Pemantau');
        $arr[]=array('id'=>1,'label'=>'Top Admin');
        $arr[]=array('id'=>2,'label'=>'Admin Kabupaten/Kota');

        return CHtml::listData($arr,'id','label');
    }

    public static function getMonthListArr()
    {
        $arr=array();
        
        $arr[]=array('id'=>'01','label'=>'Januari', 'short_lbl'=>'Jan');
        $arr[]=array('id'=>'02','label'=>'Februari', 'short_lbl'=>'Feb');
        $arr[]=array('id'=>'03','label'=>'Maret', 'short_lbl'=>'Mar');
        $arr[]=array('id'=>'04','label'=>'April', 'short_lbl'=>'Apr');
        $arr[]=array('id'=>'05','label'=>'Mei', 'short_lbl'=>'Mei');
        $arr[]=array('id'=>'06','label'=>'Juni', 'short_lbl'=>'Jun');
        $arr[]=array('id'=>'07','label'=>'Juli', 'short_lbl'=>'Jul');
        $arr[]=array('id'=>'08','label'=>'Agustus', 'short_lbl'=>'Ags');
        $arr[]=array('id'=>'09','label'=>'September', 'short_lbl'=>'Sep');
        $arr[]=array('id'=>10,'label'=>'Oktober', 'short_lbl'=>'Okt');
        $arr[]=array('id'=>11,'label'=>'November', 'short_lbl'=>'Nov');
        $arr[]=array('id'=>12,'label'=>'Desember', 'short_lbl'=>'Des');

        return $arr;
    }

    public static function getBidangBosList()
    {
        $sql="SELECT * FROM unit_kerja WHERE parent IS NULL OR (parent=1 AND jenis=1)";
        $data=Yii::app()->db->createCommand($sql)->queryAll();

        $arr=array();
        foreach ($data as $key => $value) {
            $arr[]=array('id'=>$value['id'],'label'=>$value['name']);
        }

        return CHtml::listData($arr,'id','label');
    }

    public static function getBidangList()
    {
        $sql="SELECT * FROM unit_kerja WHERE parent=1 AND jenis=1";
        $data=Yii::app()->db->createCommand($sql)->queryAll();

        $arr=array();
        foreach ($data as $key => $value) {
            $arr[]=array('id'=>$value['id'],'label'=>$value['name']);
        }

        return CHtml::listData($arr,'id','label');
    }

    public static function getKabKotaList($with_prov=false)
    {
        $sql="SELECT * FROM unit_kerja WHERE parent=1 AND jenis=2 ORDER BY code";
        $data=Yii::app()->db->createCommand($sql)->queryAll();

        $arr=array();

        if($with_prov)
            $arr[]=array('id'=>0, 'label'=>'Semua Kab/Kota');
        foreach ($data as $key => $value) {
            $arr[]=array('id'=>$value['id'],'label'=>$value['name']);
        }

        return CHtml::listData($arr,'id','label');
    }

 
    public static function getYear()
    {
        $arr=array();
        for($i=2013;$i<=2053;++$i)
        {
            $arr[]=array('id'=>$i);
        }

        return CHtml::listData($arr,'id','id');
    }

    public static function getJenisUnitKerja()
    {
        $arr=array();
        $arr[]=array('id'=>1,'label'=>'Provinsi');
        $arr[]=array('id'=>2,'label'=>'Kabupaten');

        return CHtml::listData($arr,'id','label');
    }

 
    public static function getRandomValue($len)
    {
        $cc = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rr = '';
        for ($i = 0; $i < $len; $i++)
            $rr .= $cc[rand(0, strlen($cc)-1)];
        return $rr;
    }

    public static function getListProvinsi()
    {
        $result=array();
        $all=UnitKerja::model()->findAllByAttributes(array('jenis'=>1,'parent'=>1));
        foreach ($all as $key => $value)
            $result[]=array('label'=>$value['name'],'url'=>array('site/bidang','id'=>$value['id']), 'id'=>$value['id']);
        
        return $result;
    }

    public static function getListKabupaten()
    {
        $result=array();
        $all=UnitKerja::model()->findAllByAttributes(array('jenis'=>'2'), array('order'=>'code'));
        foreach ($all as $key => $value) {
            $result[]=array('label'=>$value['name'],'url'=>array('report/kabupaten','id'=>$value['id']), 'id'=>$value['id']);
        }
        return $result;
    }

    public static function getListEselon3($with_prov=false)
    {
        $sql="SELECT * FROM unit_kerja WHERE jenis=2 OR (jenis=1 AND parent=1) ORDER BY code";
        $data=Yii::app()->db->createCommand($sql)->queryAll();

        $arr=array();

        if($with_prov)
            $arr[]=array('id'=>0, 'label'=>'Semua Unit Kerja');
        foreach ($data as $key => $value) {
            $arr[]=array('id'=>$value['id'],'label'=>$value['name']);
        }

        return CHtml::listData($arr,'id','label');
    }

    public static function getRawJenisData(){
        $result=array();
        $result[]=array('id'=>1,'label'=>'Bulanan');
        $result[]=array('id'=>2,'label'=>'Triwulanan');
        $result[]=array('id'=>3,'label'=>'Semester');
        $result[]=array('id'=>4,'label'=>'Tahunan');
        $result[]=array('id'=>5,'label'=>'Subround');

        return $result;
    }

    public static function showJenisData($value){
        foreach(self::getRawJenisData() as $curr) {
            if($curr['id'] == $value) {
                return $curr['label'];
            }
        }
    }

    public static function getJenisData()
    {
        return CHtml::listData(self::getRawJenisData(),'id','label');   
    }


    public static function getRawAnggaran(){
        $result=array();
        $result[]=array('id'=>1,'label'=>'Persiapan');
        $result[]=array('id'=>2,'label'=>'Pelatihan');
        $result[]=array('id'=>3,'label'=>'Lapangan');
        $result[]=array('id'=>4,'label'=>'Pengolahan');

        return $result;
    }

    public static function showAnggaran($value){
        foreach(self::getRawAnggaran() as $curr) {
            if($curr['id'] == $value) {
                return $curr['label'];
            }
        }
    }
    
    public static function getDropDownAnggaran(){
        return CHtml::listData(self::getRawAnggaran(),'id','label');   
    }

    //check if current user authorize for unit kerja
    public static function isAuthorizeUnitKerja($unit_kerja)
    {
        $result=false;
        $cur_user=User::model()->findByPk(Yii::app()->user->id);

        if($cur_user->unit_kerja==1)
        {
            $result=true;
        }
        else
        {
            if($cur_user!==null)
            {
                if($cur_user->unit_kerja==$unit_kerja)
                {
                    $result=true;
                }
                else
                {
                    $cur_uk=UnitKerja::model()->findByPk($unit_kerja);
                    while($cur_uk->parent!=null)
                    {
                        if($cur_uk->id==$cur_user->unit_kerja)
                        {
                            $result=true;
                            $cur_uk=UnitKerja::model()->findByPk(1);
                        }   
                        else
                        {
                            $cur_uk=UnitKerja::model()->findByPk($cur_uk->parent);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function ListAuthorizeUnitKerja()
    {
        $result=array();
        $cur_user=User::model()->findByPk(Yii::app()->user->id);
        if($cur_user->unit_kerja==1)
        {
            $result=CHtml::listData(
                UnitKerja::model()->findAllByAttributes(array('jenis'=>1),array('condition'=>'(parent<>1 AND parent IS NOT NULL)')),
                'id','name'
            );
        }
        else
        {
            if($cur_user!==null)
            {
                $model=UnitKerja::model()->findByPk($cur_user->unit_kerja);
                if($model!==null)
                {
                    if($model->parent!=1)
                    {
                        $result[]=array('id'=>$model->id,'name'=>$model->name);
                        $result=CHtml::listData($result,'id','name');
                    }
                    else
                    {
                        $result=CHtml::listData(
                            UnitKerja::model()->findAllByAttributes(array('parent'=>$model->id,'jenis'=>1)),
                            'id',
                            'name'
                        );
                    }
                }
            }
        }

        return $result;
    }

    public static function isKabupaten()
    {
        $result=false;
        $id=Yii::app()->user->id;
        $sql="SELECT uk.jenis FROM mem_user u, unit_kerja uk WHERE u.unit_kerja=uk.id AND u.id={$id}";
        $return_val=Yii::app()->db->createCommand($sql)->queryScalar();

        if($return_val==2)
            $result=true;

        return $result;
    }

    public static function ListBidangCode($id)
    {
        $label=array();
        $label[]=$id;


        foreach (UnitKerja::model()->findAllByAttributes(array('parent'=>$id)) as $key => $value) {
            $label[]=$value->id;
        }

        return implode($label, ",");
    }
}
?>