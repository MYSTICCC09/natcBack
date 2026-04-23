<?php

/**
 * This is the model class for table "natc_driver".
 *
 * The followings are the available columns in table 'natc_driver':
 * @property integer $driver_id
 * @property string $driver_fullname
 * @property string $driver_license_no
 * @property string $driver_age
 * @property string $driver_bdate
 * @property integer $status
 * @property string $driver_license_type
 */
class NatcDriver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('driver_fullname, driver_license_no, driver_age, driver_bdate, status, driver_license_type', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('driver_fullname, driver_license_no', 'length', 'max'=>50),
			array('driver_age', 'length', 'max'=>3),
			array('driver_license_type', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('driver_id, driver_fullname, driver_license_no, driver_age, driver_bdate, status, driver_license_type', 'safe', 'on'=>'search'),
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
			'driver_id' => 'Driver',
			'driver_fullname' => 'Driver Fullname',
			'driver_license_no' => 'Driver License No',
			'driver_age' => 'Driver Age',
			'driver_bdate' => 'Driver Bdate',
			'status' => 'Status',
			'driver_license_type' => 'Driver License Type',
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

		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('driver_fullname',$this->driver_fullname,true);
		$criteria->compare('driver_license_no',$this->driver_license_no,true);
		$criteria->compare('driver_age',$this->driver_age,true);
		$criteria->compare('driver_bdate',$this->driver_bdate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('driver_license_type',$this->driver_license_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcDriver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
