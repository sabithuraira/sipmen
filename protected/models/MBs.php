<?php

/**
 * This is the model class for table "m_bs".
 *
 * The followings are the available columns in table 'm_bs':
 * @property string $idProv
 * @property string $idKab
 * @property string $idKec
 * @property string $idDesa
 * @property string $nbs
 * @property string $nks
 * @property string $nks_sutas
 * @property integer $jml_eligible
 * @property string $status_terima
 * @property integer $jml_terima
 * @property string $tgl_terima
 * @property string $status_edit
 * @property integer $jml_edit
 * @property integer $jml_drop
 * @property string $tgl_edit
 * @property string $status_kirim
 * @property integer $jml_kirim
 * @property integer $nmr_kirim
 * @property string $tgl_kirim
 * @property string $nobatch
 * @property integer $nomorbatch
 */
class MBs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_bs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_terima, jml_terima, tgl_terima, status_edit, jml_edit, jml_drop, tgl_edit, status_kirim, jml_kirim, nmr_kirim, tgl_kirim, nobatch, nomorbatch', 'required'),
			array('jml_eligible, jml_terima, jml_edit, jml_drop, jml_kirim, nmr_kirim, nomorbatch', 'numerical', 'integerOnly'=>true),
			array('idProv, idKab', 'length', 'max'=>2),
			array('idKec, idDesa', 'length', 'max'=>3),
			array('nbs, nks', 'length', 'max'=>4),
			array('nks_sutas', 'length', 'max'=>7),
			array('status_terima, status_edit, status_kirim', 'length', 'max'=>1),
			array('tgl_terima, tgl_edit, tgl_kirim', 'length', 'max'=>25),
			array('nobatch', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idProv, idKab, idKec, idDesa, nbs, nks, nks_sutas, jml_eligible, status_terima, jml_terima, tgl_terima, status_edit, jml_edit, jml_drop, tgl_edit, status_kirim, jml_kirim, nmr_kirim, tgl_kirim, nobatch, nomorbatch', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'penerima' => array(self::BELONGS_TO, 'User', 'terima_by'),
		);
	}

	public function getPenerimaName(){
		if($this->terima_by!=0){
			return "<br/> Receiving Oleh: <b>(".($this->penerima->username).")</b>";
		}

		return "";
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idProv' => 'Id Prov',
			'idKab' => 'Id Kab',
			'idKec' => 'Id Kec',
			'idDesa' => 'Id Desa',
			'nbs' => 'Nbs',
			'nks' => 'Nks',
			'nks_sutas' => 'Nks Sutas',
			'jml_eligible' => 'Jml Eligible',
			'status_terima' => 'Status Terima',
			'jml_terima' => 'Jml Terima',
			'tgl_terima' => 'Tgl Terima',
			'status_edit' => 'Status Edit',
			'jml_edit' => 'Jml Edit',
			'jml_drop' => 'Jml Drop',
			'tgl_edit' => 'Tgl Edit',
			'status_kirim' => 'Status Kirim',
			'jml_kirim' => 'Jml Kirim',
			'nmr_kirim' => 'Nmr Kirim',
			'tgl_kirim' => 'Tgl Kirim',
			'nobatch' => 'Nobatch',
			'nomorbatch' => 'Nomorbatch',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idProv',$this->idProv,true);
		$criteria->compare('idKab',$this->idKab,true);
		$criteria->compare('idKec',$this->idKec,true);
		$criteria->compare('idDesa',$this->idDesa,true);
		$criteria->compare('nbs',$this->nbs,true);
		$criteria->compare('nks',$this->nks,true);
		$criteria->compare('nks_sutas',$this->nks_sutas,true);
		$criteria->compare('jml_eligible',$this->jml_eligible);
		$criteria->compare('status_terima',$this->status_terima,true);
		$criteria->compare('jml_terima',$this->jml_terima);
		$criteria->compare('tgl_terima',$this->tgl_terima,true);
		$criteria->compare('status_edit',$this->status_edit,true);
		$criteria->compare('jml_edit',$this->jml_edit);
		$criteria->compare('jml_drop',$this->jml_drop);
		$criteria->compare('tgl_edit',$this->tgl_edit,true);
		$criteria->compare('status_kirim',$this->status_kirim,true);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('nmr_kirim',$this->nmr_kirim);
		$criteria->compare('tgl_kirim',$this->tgl_kirim,true);

		// $criteria->compare('status_terima_prov',$this->status_terima_prov,true);
		$criteria->compare('nobatch',$this->nobatch,true);
		$criteria->compare('nomorbatch',$this->nomorbatch);

		if($this->status_terima_prov==0 && $this->status_terima_prov!=''){
			// print_r($this);
			// print_r("satu");die();
			$criteria->addCondition('status_terima_prov<>1');
		}
		else if($this->status_terima_prov==1){
			// print_r("dua");die();
			$criteria->addCondition('status_terima_prov=1');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getCetak()
	{
		$where = "";

		if($this->idKab!=null && $this->idKab!=0){
			$where = "bs.idKab = '".$this->idKab."' AND ";
		}

		if($this->idKec!=null && $this->idKec!=0){
			$where = "bs.idKec = '".$this->idKec."' AND ";
		}

		if($this->idDesa!=null && $this->idDesa!=0){
			$where = "bs.idDesa = '".$this->idDesa."' AND ";
		}

		$sql = "SELECT bs.idKab, kab.nmKab, bs.idKec, kec.nmKec, bs.idDesa, desa.nmDesa, 
				bs.nbs, bs.nks, bs.nks_sutas, bs.jml_terima_prov, bs.tgl_terima_prov 
				FROM m_bs bs, 
				m_kab kab, m_kec kec, m_desa desa
				WHERE 
				$where
				status_terima_prov = 1 AND 
				kirim_ipds = 0 AND 
				kab.idKab = bs.idKab AND 
				(kec.idKab = bs.idKab AND kec.idKec = bs.idKec) AND 
				(desa.idKab = bs.idKab AND desa.idKec = bs.idKec AND desa.idDesa = bs.idDesa)";

		$data =  Yii::app()->db->createCommand($sql)->queryAll();

		// $result = array();
		// foreach($data as $key=>$value){
		// 	$result[] = array(
		// 		'idKab' => $value['idKab'],
		// 		'nmKab' => $value['nmKab'],
		// 		'idKec' => $value['idKec'],
		// 		'nmKec' => $value['nmKec'],
		// 		'idDesa' => $value['idDesa'],
		// 		'nmDesa' => $value['nmDesa'],
		// 		'nbs' => $value['nbs'],
		// 		'nks' => $value['nks'],
		// 		'nks_sutas' => $value['nks_sutas'],
		// 		'jml_terima_prov' => $value['jml_terima_prov']
		// 	);
		// }

		return $data;
	}

	public function getLabelProv()
	{
		return "(16) SUMATERA SELATAN";
	}

	public function getLabelKab(){
		$model = MKab::model()->findByAttributes(array('idProv'=>$this->idProv, 'idKab'=>$this->idKab));

		return "(".$this->idKab.") ".$model->nmKab;
	}

	public function getLabelKec(){
		$model = MKec::model()->findByAttributes(array('idProv'=>$this->idProv, 'idKab'=>$this->idKab, 'idKec'=>$this->idKec));

		return "(".$this->idKec.") ".$model->nmKec;
	}

	public function getLabelDesa(){
		$model = MDesa::model()->findByAttributes(array('idProv'=>$this->idProv, 'idKab'=>$this->idKab, 'idKec'=>$this->idKec, 'idDesa'=>$this->idDesa));

		return "(".$this->idDesa.") ".$model->nmDesa;
	}

	public function getStatusTerimaLabel(){
		if($this->status_terima==0)
			return '<div class="label bg-red">BELUM TERIMA TU</div>';
		else 
			return '<div class="label bg-green">SUDAH TERIMA TU</div>';
	}

	public function getStatusKirimLabel(){
		if($this->status_kirim==0)
			return '<div class="label bg-red">BELUM KIRIM</div>';
		else 
			return '<div class="label bg-green">SUDAH KIRIM</div>';
	}

	public function getStatusEditLabel(){
		if($this->status_edit==0)
			return '<div class="label bg-red">BELUM EDIT</div>';
		else 
			return '<div class="label bg-green">SUDAH EDIT</div>';
	}

	public function getStatusTerimaProvLabel(){
		if($this->status_terima_prov==0)
			return '<div class="label bg-red">BELUM TERIMA PROV</div>';
		else 
			return '<div class="label bg-green">SUDAH TERIMA PROV</div>';
	}

	//when user delete a RUTA on terima process, it will update all number of terima, edit, kirim & terima_prov
	public function updateJumlah(){
		$total_terima_prov = MRuta::model()->countByAttributes(array(
			''
		));
	}

	public function getRekap($id_kab=null, $id_kec=null, $id_desa= null){
		$select = '
				sum(1) as total_bs,
				sum(case status_terima when 1 then 1 else 0 end) as terima,
				sum(case status_terima when 1 then jml_terima else 0 end) as terima_ruta,
				sum(case status_edit when 1 then 1 else 0 end) as editing,
				sum(case status_edit when 1 then jml_edit else 0 end) as editing_ruta,
				sum(case status_kirim when 1 then 1 else 0 end) as kirim,
				sum(case status_kirim when 1 then jml_kirim else 0 end) as kirim_ruta,
				sum(case status_terima_prov when 1 then 1 else 0 end) as terima_prov,
				sum(case status_terima_prov when 1 then jml_terima_prov else 0 end) as terima_prov_ruta';

		$sql = "SELECT k.idKab as kode, k.nmKab as nama, $select
			FROM `m_bs` bs, m_kab k WHERE 
            bs.idKab = k.idKab
			GROUP BY bs.idKab";

		if($id_kab!=null && $id_kab!=0){
			$sql = "SELECT kec.idKec as kode,  kec.nmKec as nama, $select
				FROM `m_bs` bs, m_kab k, m_kec kec WHERE 
				bs.idKab = ".$id_kab." AND 
				kec.idKab = ".$id_kab." AND 
                bs.idKab = k.idKab AND 
				bs.idKec = kec.idKec 
				GROUP BY bs.idKec";

			if($id_kec!=null && $id_kec!=0){
				$sql = "SELECT desa.idDesa as kode,  desa.nmDesa as nama, $select
					FROM `m_bs` bs, m_kab k, m_kec kec, m_desa desa WHERE 
					bs.idKab = ".$id_kab." AND
					bs.idKec = ".$id_kec." AND 

					kec.idKab = ".$id_kab." AND 
					desa.idKab = ".$id_kab." AND 
					desa.idKec = ".$id_kec." AND 

					bs.idKab = k.idKab AND 
					bs.idKec = kec.idKec AND 
					bs.idDesa = desa.idDesa 
					GROUP BY bs.idDesa";
			}


			if($id_desa!=null && $id_desa!=0){
				$sql = "SELECT nbs as kode,  nks_sutas as nama, $select
					FROM `m_bs` WHERE 
					idKab = ".$id_kab." AND
					idKec = ".$id_kec." AND 
					idDesa = ".$id_desa." ";
			}
		}

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function getRekapOp($id_kab=null, $id_kec=null, $id_desa= null){
		$select = 'sum(case status_terima_prov when 1 then 1 else 0 end) as total, 
					sum(case status_terima_prov when 1 then jml_terima_prov else 0 end) as total_ruta';

		$where = "bs.terima_by = u.id ";


		if($id_kab!=null && $id_kab!=0){
			$where .= " AND bs.idKab = ".$id_kab;

			if($id_kec!=null && $id_kec!=0){
				$where .= "AND bs.idKec = ".$id_kec;

				if($id_desa!=null && $id_desa!=0){
					$where .= "AND bs.idDesa = ".$id_desa;
				}
			}
		}

		$sql = "SELECT u.id, u.username as nama, $select
				FROM `m_bs` bs, mem_user u WHERE 
				$where
				GROUP BY u.id";

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function reset($id, $kab){
		$model=$this->findByAttributes(array('nks_sutas'=>$id, 'idKab'=> $kab));
		
		if($model->nobatch!=''){
			//delete ruta
			$sql = "DELETE FROM m_ruta WHERE idKab='".$kab."' AND nobatch='".$model->nobatch."' ";
			Yii::app()->db->createCommand($sql)->execute();

			//delete batch
			$model_batch = MBatch::model()->findByAttributes(array('idKab'=>$kab, 'nobatch'=>$model->nobatch));
			$model_batch->status = 1;
			$model_batch->save(false);
		}

		//reset bs
		$sql = "UPDATE m_bs SET 
			status_terima='', jml_terima=0, tgl_terima = '', 
			status_edit='', jml_edit=0, jml_drop = 0, tgl_edit = '',
			status_kirim='', jml_kirim=0, nmr_kirim = 0, tgl_kirim = '',
			status_terima_prov='', jml_terima_prov=0, tgl_terima_prov = '', terima_by = 0
			WHERE nks_sutas='".$id."' AND idKab='".$kab."' "; 

		Yii::app()->db->createCommand($sql)->execute();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MBs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
