<?php
class ReportMe
{
    public static function WilayahThisYear($bidang=1,$tahun)
    {
        $label_where="";
        if($bidang!=1)
        {
            $listbidang=HelpMe::ListBidangCode($bidang);
            $label_where=" AND k.unit_kerja IN({$listbidang})";
        }

        $sql="SELECT COUNT(p.id) as jumlah_kegiatan, SUM(timelines_point) as jumlah_point, SUM(target) as jumlah_target ,
                (SUM(timelines_point)/COUNT(p.id)) as point, unitkerja, u.name FROM `participant` p, unit_kerja u, kegiatan k 
                WHERE u.id=p.unitkerja AND k.id=p.kegiatan 
                AND YEAR(end_date)={$tahun} AND end_date<=DATE(NOW()) $label_where
                GROUP BY unitkerja
                ORDER BY point DESC, jumlah_target DESC, jumlah_kegiatan DESC";

        if(Yii::app()->user->getUnitKerja()!=1)
        {
            $sql.=" LIMIT 5";
        }

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public static function Peringkat1Tahunan($tahun)
    {
        $sql="SELECT COUNT(p.id) as jumlah_kegiatan, SUM(timelines_point) as jumlah_point, SUM(target) as jumlah_target ,
                (SUM(timelines_point)/COUNT(p.id)) as point, unitkerja, u.name FROM `participant` p, unit_kerja u, kegiatan k 
                WHERE u.id=p.unitkerja AND k.id=p.kegiatan 
                AND YEAR(end_date)={$tahun} AND end_date<=DATE(NOW()) 
                GROUP BY unitkerja
                ORDER BY point DESC, jumlah_target DESC, jumlah_kegiatan DESC 
                LIMIT 1";

        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $data['url'] = Yii::app()->createUrl('site/peringkat');

        return $data;
    }

    public static function Peringkat1Bulanan($year,$month)
    {
        $sql="SELECT COUNT(p.id) as jumlah_kegiatan, SUM(timelines_point) as jumlah_point, SUM(target) as jumlah_target ,
                (SUM(timelines_point)/COUNT(p.id)) as point, unitkerja, u.name FROM `participant` p, unit_kerja u, kegiatan k 
                WHERE u.id=p.unitkerja AND k.id=p.kegiatan 
                AND YEAR(end_date)={$year} AND MONTH(end_date)={$month} 
                GROUP BY unitkerja
                ORDER BY point DESC, jumlah_target DESC, jumlah_kegiatan DESC 
                LIMIT 1";
                
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        $data['url'] = Yii::app()->createUrl('site/peringkat_month');

        return $data;
    }

    public static function ValuePerKabBidang($bidang,$kab,$tahun)
    {
        $label_where="";

        $listbidang=HelpMe::ListBidangCode($bidang);
        $label_where=" AND k.unit_kerja IN({$listbidang}) AND unitkerja={$kab}";

        $sql="SELECT COUNT(p.id) as jumlah_kegiatan, SUM(timelines_point) as jumlah_point, SUM(target) as jumlah_target ,
                (SUM(timelines_point)/COUNT(p.id)) as point, unitkerja, u.name FROM `participant` p, unit_kerja u, kegiatan k 
                WHERE u.id=p.unitkerja AND k.id=p.kegiatan 
                AND YEAR(end_date)={$tahun} AND end_date<=DATE(NOW()) $label_where ";

        $data=0;
        $result=Yii::app()->db->createCommand($sql)->queryAll();
        if(count($result)>0)
            $data=number_format($result[0]['point'],2);
        return $data;
    }



    public static function WilayahTahunBulan($year,$month,$bidang)
    {
        $label_where="";
        if($bidang!=1)
        {
            $listbidang=HelpMe::ListBidangCode($bidang);
            $label_where=" AND k.unit_kerja IN({$listbidang})";
        }

        $sql="SELECT COUNT(p.id) as jumlah_kegiatan, SUM(timelines_point) as jumlah_point, SUM(target) as jumlah_target ,
                (SUM(timelines_point)/COUNT(p.id)) as point, unitkerja, u.name FROM `participant` p, unit_kerja u, kegiatan k 
                WHERE u.id=p.unitkerja AND k.id=p.kegiatan 
                AND YEAR(end_date)={$year} AND MONTH(end_date)={$month} $label_where
                GROUP BY unitkerja
                ORDER BY point DESC, jumlah_target DESC, jumlah_kegiatan DESC";

        if(Yii::app()->user->getUnitKerja()!=1)
        {
            $sql.=" LIMIT 5";
        }

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public static function TotalKegiatan($tahun)
    {
        $sql="SELECT COUNT(*) FROM kegiatan WHERE YEAR(end_date)={$tahun}";
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }

    //get all kegiatan by month
    public static function KegiatanKabupaten($id,$tahun)
    {
        $sql="SELECT k.id,k.kegiatan, k.end_date, MONTHNAME(end_date) as bulan, p.target,p.timelines_point 
            FROM kegiatan k,participant p 
            WHERE p.kegiatan=k.id AND p.unitkerja={$id} AND YEAR(end_date)={$tahun} 
            ORDER BY end_date";

        $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); 
        //return Yii::app()->db->createCommand($sql)->queryAll();
        $rawData = Yii::app()->db->createCommand($sql);

        $model = new CSqlDataProvider($rawData, array( //or $model=new CArrayDataProvider($rawData, array(... //using with querAll...
                    'keyField' => 'id', 
                    'totalItemCount' => $count,
                    'pagination' => array(
                        'pageSize' => 15,
                    ),
                ));

        return $model;
    }

    public static function KabupatenPerMonth($id,$tahun)
    {
        $sql="SELECT (SUM(timelines_point)/COUNT(p.id)) as nilai, MONTH(end_date) as bulan 
            FROM kegiatan k,participant p 
            WHERE p.kegiatan=k.id AND p.unitkerja={$id} AND YEAR(end_date)={$tahun} 
            GROUP BY bulan
            ORDER BY MONTH(end_date)";

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public static function PaguTargetSatker($tahun, $code){
        $sum_str="";
        $case_str="";
        for($i=1;$i<=12;++$i){
            $sum_str.=", sum(tt$i) as bl$i";
            $case_str.=", CASE WHEN ps.bulan=$i THEN sum(ps.jumlah) else 0 end tt$i";
        }
        $sum_str.=", sum(ttotal) as bltotal ";
        $case_str.=", SUM(ps.jumlah) ttotal";

        $sql="select label $sum_str     
                from
                (
                select idk.label $case_str
                from m_induk idk
                LEFT JOIN pagu_satker ps ON ps.m_induk=idk.id 
                WHERE ps.tahun={$tahun} AND unit_kerja={$code}
                GROUP BY idk.label, ps.bulan
                ) summary
                GROUP BY label 
                ORDER BY label";

        return Yii::app()->db->createCommand($sql)->queryAll();
    }
}
?>