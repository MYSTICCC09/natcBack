<?php

/**
 * This is the model class for table "natc_booking".
 *
 * The followings are the available columns in table 'natc_booking':
 * @property integer $booking_id
 * @property string $booking_no
 * @property string $booking_date
 * @property string $booking_time
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property integer $status
 * @property string $booking_fare
 * @property string $name
 * @property string $phone
 * @property string $pickup
 * @property string $email
 * @property string $vehicle_type
 * @property integer $passengers
 * @property integer $luggage
 * @property string $notes
 */
class NatcBooking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_booking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, pickup, email, vehicle_type, passengers, luggage, notes', 'required'),
			array('driver_id, vehicle_id, status, passengers, luggage', 'numerical', 'integerOnly'=>true),
			array('booking_no, booking_fare, vehicle_type', 'length', 'max'=>10),
			array('name', 'length', 'max'=>100),
			array('phone, pickup', 'length', 'max'=>20),
			array('email', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('booking_id, booking_no, booking_date, booking_time, driver_id, vehicle_id, status, booking_fare, name, phone, pickup, email, vehicle_type, passengers, luggage, notes', 'safe', 'on'=>'search'),
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
			'booking_id' => 'Booking',
			'booking_no' => 'Booking No',
			'booking_date' => 'Booking Date',
			'booking_time' => 'Booking Time',
			'driver_id' => 'Driver',
			'vehicle_id' => 'Vehicle',
			'status' => 'Status',
			'booking_fare' => 'Booking Fare',
			'name' => 'Name',
			'phone' => 'Phone',
			'pickup' => 'Pickup',
			'email' => 'Email',
			'vehicle_type' => 'Vehicle Type',
			'passengers' => 'Passengers',
			'luggage' => 'Luggage',
			'notes' => 'Notes',
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

		$criteria->compare('booking_id',$this->booking_id);
		$criteria->compare('booking_no',$this->booking_no,true);
		$criteria->compare('booking_date',$this->booking_date,true);
		$criteria->compare('booking_time',$this->booking_time,true);
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('booking_fare',$this->booking_fare,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('pickup',$this->pickup,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('vehicle_type',$this->vehicle_type,true);
		$criteria->compare('passengers',$this->passengers);
		$criteria->compare('luggage',$this->luggage);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcBooking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
