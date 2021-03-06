<?php

/**
 * This is the model class for table "m_desa".
 *
 * The followings are the available columns in table 'm_desa':
 * @property string $idProv
 * @property string $idKab
 * @property string $idKec
 * @property string $idDesa
 * @property string $nmDesa
 */
class MDesa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_desa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idProv, idKab', 'length', 'max'=>2),
			array('idKec, idDesa', 'length', 'max'=>3),
			array('nmDesa', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idProv, idKab, idKec, idDesa, nmDesa', 'safe', 'on'=>'search'),
		);
	}

	public function getKodeNama(){
		return "(".$this->idDesa.") ".$this->nmDesa;
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
			'idKec' => 'Id Kec',
			'idDesa' => 'Id Desa',
			'nmDesa' => 'Nm Desa',
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
		$criteria->compare('nmDesa',$this->nmDesa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MDesa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
