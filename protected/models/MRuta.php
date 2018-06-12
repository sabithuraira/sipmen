<?php

/**
 * This is the model class for table "m_ruta".
 *
 * The followings are the available columns in table 'm_ruta':
 * @property string $idProv
 * @property string $idKab
 * @property string $nobatch
 * @property string $noruta
 * @property string $namakrt
 * @property string $status
 * @property string $ket_status
 */
class MRuta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_ruta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idProv, idKab, nobatch, noruta, namakrt, status, ket_status', 'required'),
			array('idProv, idKab', 'length', 'max'=>2),
			array('nobatch', 'length', 'max'=>9),
			array('noruta', 'length', 'max'=>3),
			array('namakrt', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idProv, idKab, nobatch, noruta, namakrt, status, ket_status', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idProv' => 'Id Prov',
			'idKab' => 'Id Kab',
			'nobatch' => 'Nobatch',
			'noruta' => 'Noruta',
			'namakrt' => 'Namakrt',
			'status' => 'Status',
			'ket_status' => 'Ket Status',
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
		$criteria->compare('noruta',$this->noruta,true);
		$criteria->compare('namakrt',$this->namakrt,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('ket_status',$this->ket_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MRuta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
