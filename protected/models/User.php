<?php

/**
 * This is the model class for table "mem_user".
 *
 * The followings are the available columns in table 'mem_user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $unit_kerja
 * @property string $created_time
 * @property string $last_login
 *
 * The followings are the available model relations:
 * @property UnitKerja $unitKerja
 */
class User extends CActiveRecord
{
	public $password2;
	public $old_password;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mem_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password, unit_kerja, created_time', 'required'),
			array('unit_kerja', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>45),
			array('email, password', 'length', 'max'=>255),
			array('last_login', 'safe'),
			array('password2', 'required','on'=>'register'),
			array('password2', 'compare','compareAttribute'=>'password','on'=>'register'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, password, unit_kerja, created_time, last_login', 'safe', 'on'=>'search'),
		);
	}

	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
			$this->created_time=date('Y-m-d h:i:s');
		}

		return parent::beforeValidate();
	}

	public function beforeSave()
    {
        if($this->isNewRecord)
        {    
            $pword=$this->password;
            $this->password = CPasswordHelper::hashPassword($pword);
        }
        return parent::beforeSave();
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
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'unit_kerja' => 'Unit Kerja',
			'created_time' => 'Created Time',
			'last_login' => 'Last Login',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('unit_kerja',$this->unit_kerja);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
