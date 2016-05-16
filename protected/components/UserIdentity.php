<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	 
	
	public function authenticate()
	{
		$userid="";
		$privileges=0;
		$op=Users::model()->findByAttributes(array('name'=>$this->username));



		if($op==null) $this->errorCode=self::ERROR_USERNAME_INVALID;
		else{
			$key=hex2bin($op->salt);
                        $hashed=strtoupper(bin2hex(hash_pbkdf2("sha1",$this->password,$key,1000,24,true)));

			if($hashed!=$op->hashedpassword) $this->errorCode=self::ERROR_PASSWORD_INVALID;
			else{
				$this->errorCode=self::ERROR_NONE;			
				Yii::app()->session['name']=$op->name;			
				Yii::app()->session['loginid']=$op->name;
				Yii::app()->session['privileges']=1; 			
			}
		}
		return !$this->errorCode;
	}
	
	public static function isAdmin(){
		return (isset(Yii::app()->session['privileges']) && Yii::app()->session['privileges']==1);		
	}
	public static function isOperator(){
		return (isset(Yii::app()->session['privileges']) && Yii::app()->session['privileges']==2);		
	}
	
}
