<?php

/**
 * This is the model class for table "devices".
 *
 * The followings are the available columns in table 'devices':
 * @property integer $id
 * @property string $name
 * @property string $uniqueid
 * @property string $status
 * @property string $lastupdate
 * @property integer $positionid
 * @property string $notelp
 * @property string $merek
 * @property string $tipe
 * @property integer $port
 * @property string $protocol
 * @property string $settingan
 * @property string $u_password
 * @property string $u_fullname
 * @property string $u_email
 * @property string $u_address
 *
 * The followings are the available model relations:
 * @property UserDevice[] $userDevices
 * @property Positions[] $positions
 */
class Devices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'devices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, uniqueid', 'required'),
			array('positionid, port', 'numerical', 'integerOnly'=>true),
			array('name, uniqueid, status', 'length', 'max'=>128),
			array('notelp, merek, tipe, protocol', 'length', 'max'=>20),
			array('u_password', 'length', 'max'=>50),
			array('u_fullname', 'length', 'max'=>100),
			array('u_email, u_address', 'length', 'max'=>255),
			array('lastupdate, settingan', 'safe'),

			  
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, uniqueid, status, lastupdate, positionid, notelp, merek, tipe, port, protocol, settingan, u_password, u_fullname, u_email, u_address', 'safe', 'on'=>'search'),
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
			'userDevices' => array(self::HAS_MANY, 'UserDevice', 'deviceid'),
			'positions' => array(self::HAS_MANY, 'Positions', 'deviceid'),
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
			'uniqueid' => 'Uniqueid',
			'status' => 'Status',
			'lastupdate' => 'Lastupdate',
			'positionid' => 'Positionid',
			'notelp' => 'Notelp',
			'merek' => 'Merek',
			'tipe' => 'Tipe',
			'port' => 'Port',
			'protocol' => 'Protocol',
			'settingan' => 'Settingan',
			'u_password' => 'U Password',
			'u_fullname' => 'U Fullname',
			'u_email' => 'U Email',
			'u_address' => 'U Address',


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
		$criteria->compare('uniqueid',$this->uniqueid,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('lastupdate',$this->lastupdate,true);
		$criteria->compare('positionid',$this->positionid);
		$criteria->compare('notelp',$this->notelp,true);
		$criteria->compare('merek',$this->merek,true);
		$criteria->compare('tipe',$this->tipe,true);
		$criteria->compare('port',$this->port);
		$criteria->compare('protocol',$this->protocol,true);
		$criteria->compare('settingan',$this->settingan,true);
		$criteria->compare('u_password',$this->u_password,true);
		$criteria->compare('u_fullname',$this->u_fullname,true);
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('u_address',$this->u_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>500),			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Devices the static model class
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
