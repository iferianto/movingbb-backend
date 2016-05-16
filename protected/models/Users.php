<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $hashedpassword
 * @property string $salt
 * @property boolean $readonly
 * @property boolean $admin
 * @property string $map
 * @property string $language
 * @property string $distanceunit
 * @property string $speedunit
 * @property double $latitude
 * @property double $longitude
 * @property integer $zoom
 *
 * The followings are the available model relations:
 * @property UserDevice[] $userDevices
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	public $password="";

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, hashedpassword, salt', 'required'),
			array('zoom', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('name, email, hashedpassword, salt, map, language, distanceunit, speedunit', 'length', 'max'=>128),
			array('readonly, admin', 'safe'),

			  
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, hashedpassword, salt, readonly, admin, map, language, distanceunit, speedunit, latitude, longitude, zoom', 'safe', 'on'=>'search'),
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
			'userDevices' => array(self::HAS_MANY, 'UserDevice', 'userid'),
		);
	}



		
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'email' => 'Email',
			'hashedpassword' => 'Hashedpassword',
			'salt' => 'Salt',
			'readonly' => 'Readonly',
			'admin' => 'Admin',
			'map' => 'Map',
			'language' => 'Language',
			'distanceunit' => 'Distanceunit',
			'speedunit' => 'Speedunit',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'zoom' => 'Zoom',


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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('hashedpassword',$this->hashedpassword,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('admin',$this->admin);
		$criteria->compare('map',$this->map,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('distanceunit',$this->distanceunit,true);
		$criteria->compare('speedunit',$this->speedunit,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('zoom',$this->zoom);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>500),			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	

	
	
	//function custom setelah searching
	protected function afterFind(){
		parent::afterFind();
	
	}
	
	
	public function beforeSave(){
		return parent::beforeSave();		
	}	
	
		
	
	
	
	
}
