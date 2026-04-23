<?php

/**
 * This is the model class for table "natc_vehicles".
 *
 * The followings are the available columns in table 'natc_vehicles':
 * @property integer $vehicle_id
 * @property string $brand
 * @property string $plate_no
 * @property string $color
 * @property string $model
 * @property string $unit_no
 */
class NatcVehicles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_vehicles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brand, plate_no, color, model, unit_no', 'required'),
			array('brand, model, unit_no', 'length', 'max'=>20),
			array('plate_no, color', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vehicle_id, brand, plate_no, color, model, unit_no', 'safe', 'on'=>'search'),
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
			'vehicle_id' => 'Vehicle',
			'brand' => 'Brand',
			'plate_no' => 'Plate No',
			'color' => 'Color',
			'model' => 'Model',
			'unit_no' => 'Unit No',
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

		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('plate_no',$this->plate_no,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('unit_no',$this->unit_no,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcVehicles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
