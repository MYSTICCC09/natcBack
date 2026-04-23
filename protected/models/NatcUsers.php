<?php

/**
 * This is the model class for table "natc_users".
 *
 * The followings are the available columns in table 'natc_users':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $user_type
 * @property string $user_fullname
 * @property string $contact
 * @property string $email_address
 */
class NatcUsers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'natc_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, user_type, user_fullname, contact, email_address', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('username, email_address', 'length', 'max'=>60),
			array('user_type', 'length', 'max'=>10),
			array('user_fullname', 'length', 'max'=>50),
			array('contact', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, password, status, user_type, user_fullname, contact, email_address', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'user_type' => 'User Type',
			'user_fullname' => 'User Fullname',
			'contact' => 'Contact',
			'email_address' => 'Email Address',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_type',$this->user_type,true);
		$criteria->compare('user_fullname',$this->user_fullname,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('email_address',$this->email_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NatcUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
