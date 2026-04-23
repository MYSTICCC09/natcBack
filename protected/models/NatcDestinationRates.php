<?php

/**
 * This is the model class for table "natc_destination_rates".
 *
 * The followings are the available columns in table 'natc_destination_rates':
 * @property integer $dr_id
 * @property string $dr_destination
 * @property string $dr_locations
 * @property string $dr_rate_innova
 * @property string $dr_rate_van
 */
class NatcDestinationRates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_destination_rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dr_destination, dr_locations, dr_rate_innova, dr_rate_van', 'required'),
			array('dr_destination', 'length', 'max'=>100),
			array('dr_rate_innova, dr_rate_van', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dr_id, dr_destination, dr_locations, dr_rate_innova, dr_rate_van', 'safe', 'on'=>'search'),
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
			'dr_id' => 'Dr',
			'dr_destination' => 'Dr Destination',
			'dr_locations' => 'Dr Locations',
			'dr_rate_innova' => 'Dr Rate Innova',
			'dr_rate_van' => 'Dr Rate Van',
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

		$criteria->compare('dr_id',$this->dr_id);
		$criteria->compare('dr_destination',$this->dr_destination,true);
		$criteria->compare('dr_locations',$this->dr_locations,true);
		$criteria->compare('dr_rate_innova',$this->dr_rate_innova,true);
		$criteria->compare('dr_rate_van',$this->dr_rate_van,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcDestinationRates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
