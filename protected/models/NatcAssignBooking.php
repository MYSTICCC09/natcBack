<?php

/**
 * This is the model class for table "natc_assign_booking".
 *
 * The followings are the available columns in table 'natc_assign_booking':
 * @property integer $ab_id
 * @property integer $booking_id
 * @property integer $vd_id
 * @property integer $status
 * @property string $date_assigned
 */
class NatcAssignBooking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_assign_booking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_id, vd_id, status, date_assigned', 'required'),
			array('booking_id, vd_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ab_id, booking_id, vd_id, status, date_assigned', 'safe', 'on'=>'search'),
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
			'ab_id' => 'Ab',
			'booking_id' => 'Booking',
			'vd_id' => 'Vd',
			'status' => 'Status',
			'date_assigned' => 'Date Assigned',
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

		$criteria->compare('ab_id',$this->ab_id);
		$criteria->compare('booking_id',$this->booking_id);
		$criteria->compare('vd_id',$this->vd_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_assigned',$this->date_assigned,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcAssignBooking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
