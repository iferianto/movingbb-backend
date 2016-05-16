<?php

/**
 * This is the model class for table "banner_route".
 *
 * The followings are the available columns in table 'banner_route':
 * @property string $id
 * @property integer $device_id
 * @property string $osm_id
 * @property string $name
 * @property string $checkin_time
 * @property string $checkout_time
 * @property integer $score
 * @property double $latitude
 * @property double $longitude
 */
class BannerRoute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banner_route';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, score', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			array('osm_id, name, checkin_time, checkout_time', 'safe'),

			  
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, device_id, osm_id, name, checkin_time, checkout_time, score, latitude, longitude', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'device_id' => 'Device',
			'osm_id' => 'Osm',
			'name' => 'Name',
			'checkin_time' => 'Checkin Time',
			'checkout_time' => 'Checkout Time',
			'score' => 'Score',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',


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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('osm_id',$this->osm_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('checkin_time',$this->checkin_time,true);
		$criteria->compare('checkout_time',$this->checkout_time,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>500),			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BannerRoute the static model class
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
