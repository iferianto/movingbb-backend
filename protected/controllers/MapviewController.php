<?php

class MapviewController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			
		);
	}
	
	public function actionIndex()
	{
	        $mode="device";
		$info=array('type'=>'');
    	        if(isset($_REQUEST['deviceid'])){
		   $deviceid=$_REQUEST['deviceid'];
		   $sql=sprintf("select p.deviceid,p.latitude,p.longitude,d.name,d.status,d.uniqueId,d.protocol,d.tipe,d.merek from positions p left join devices d on d.id=p.deviceid where p.deviceid='%s' order by deviceTime DESC limit 1",$deviceid);
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();
		   if($rs){$info=$rs;$info['name']="Device: ".$rs['name'];$info['type']='device'; }
		}
		elseif(isset($_REQUEST['osm_id'])){
		   $osm_id=$_REQUEST['osm_id'];
                   $sql=sprintf("SELECT osm_id as street_id,name AS street_name,ST_XMin(ST_PointN(ST_TRANSFORM(way,4326),3)) as longitude,ST_YMin(ST_PointN(ST_TRANSFORM(way,4326),3)) as latitude FROM planet_osm_roads WHERE osm_id='%s'",$osm_id);
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();
		   if($rs){ $info=$rs; $info['name']="Road: ".$rs['street_name'];$info['type']='road'; }
		}else{
                   $deviceid=4;
                   $sql=sprintf("select p.deviceid,p.latitude,p.longitude,d.name,d.status,d.uniqueId,d.protocol,d.tipe,d.merek from positions p left join devices d on d.id=p.deviceid where p.deviceid='%s' order by deviceTime DESC limit 1",$deviceid);
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();
		   if($rs){ $info=$rs;$info['name']="Device: ".$rs['name'];$info['type']='device'; $deviceid=$info['deviceid'];}
		}
		$this->render('maps',array('mode'=>$mode,'info'=>$info));
	}
}
