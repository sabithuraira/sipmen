<?php

/**
 * This is the model class for table "m_batch".
 *
 * The followings are the available columns in table 'm_batch':
 * @property string $idProv
 * @property string $idKab
 * @property string $nobatch
 * @property integer $nomorbatch
 * @property string $status
 */
class MBatch extends CActiveRecord
{
	//status 1=terima TU, 2=editing, 3=kirim, 4=terima provinsi
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_batch';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idProv, idKab, nobatch, nomorbatch, status', 'required'),
			array('nomorbatch', 'numerical', 'integerOnly'=>true),
			array('idProv, idKab', 'length', 'max'=>2),
			array('nobatch', 'length', 'max'=>9),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idProv, idKab, nobatch, nomorbatch, status', 'safe', 'on'=>'search'),
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
		);
	}

	public static function getNextBatch($id){
		$total = MBatch::model()->countByAttributes(array('idKab'=>$id));
		$nextNumber = $total + 1;

		$label = '16'.$id;

		if($nextNumber < 10)
			$label .= '0000'.$nextNumber;
		else if($nextNumber >=10 && $nextNumber< 100)
			$label .= '000'.$nextNumber;
		else if($nextNumber>=100 && $nextNumber< 1000)
			$label .= '00'.$nextNumber;
		else if($nextNumber>=1000 && $nextNumber< 10000)
			$label .= '0'.$nextNumber;
		else
			$label .= $nextNumber; 

		return array(
			'nomor'	=>$nextNumber,
			'label'	=>$label
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idProv' => 'Id Prov',
			'idKab' => 'Id Kab',
			'nobatch' => 'Nobatch',
			'nomorbatch' => 'Nomorbatch',
			'status' => 'Status',
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
		$criteria->compare('nobatch',$this->nobatch,true);
		$criteria->compare('nomorbatch',$this->nomorbatch);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MBatch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
