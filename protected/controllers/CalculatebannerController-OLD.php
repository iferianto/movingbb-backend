<?php

class CalculatebannerControllerOLD extends Controller
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
	
	
	function snap2roads($url){
		//echo $url."<br>";
		//set_time_limit(0);
		$start = microtime(true);
		$result = file_get_contents($url);
		$elapsedtime=microtime(true)-$start;
		$snaproads=json_decode($result);
		//printf("Query took %1\$.5f seconds.\n\n", $elapsedtime);
		return $snaproads;
	}

	function getStreetById($id){
		$url="https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyDrlTRMCChZ6b9fhgLjDun-kpeSO2xo41o&placeid=".$id;
		//echo $url."<br>";
		$start = microtime(true);
		$result = file_get_contents($url);
		$elapsedtime=microtime(true)-$start;
		$street=json_decode($result);
		//printf("Query took %1\$.5f seconds.\n\n", $elapsedtime);
		return $street;
	}

	function insertStreet($place_id){
		$sql=sprintf("select r.street_id,r.street_name,r.weight from roadweight r inner join placeid p on r.street_id=p.street_id where p.place_id='%s' limit 1",$place_id);
		//echo $sql."<br>";		
		$street=array('id'=>0,'weight'=>0,'name'=>'','recstate'=>'');	
		$rs=Yii::app()->db->createCommand($sql)->queryRow();
		if($rs!=null){
			$street['id']=$rs['street_id'];
			$street['name']=$rs['street_name'];
			$street['weight']=$rs['weight'];
			$street['recstate']='old';
		}else{
		   $sql=sprintf("select r.street_id,r.street_name,r.weight from roadweight r inner join placeid p on r.street_id=p.street_id where p.place_id='%s'",$place_id);
		   //echo $sql."<br>";		   
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();
		   if($rs!=null){
 			   $street['id']=$rs['street_id'];
			   $street['name']=$rs['street_name'];
 			   $street['weight']=$rs['weight'];			
			   $street['recstate']='old';
		   }else{
			   $detail=$this->getStreetById($place_id);	
			   if($detail!=null){
			      if(isset($detail->status) && $detail->status=='NOT_FOUND'){
					  //insert to roadweight
			          $sql=sprintf("replace into roadweight(street_id,street_name,weight,lat,lon)values('%s','%s','%s','%s','%s')",
			          $place_id,"UNKNOWN",0,0,0);
			          //echo $sql."<br>";
			          Yii::app()->db->createCommand($sql)->execute();
			       
			          //insert to placeid 
			          $sql=sprintf("replace into placeid(place_id,street_id) values('%s','%s')",$place_id,$place_id);
			          Yii::app()->db->createCommand($sql)->execute();
			          //echo $sql."<br>";
				  
				  }elseif(isset($detail->result) && isset($detail->result->id)){
			          $street_id=$detail->result->id;
			          $lat=$detail->result->geometry->location->lat;
			          $lon=$detail->result->geometry->location->lng;
			          $street_name=$detail->result->name;
					  
					  //if($detail->result->id=='49b342e6c2cd046acbd9154117fad5ee4b1314a9'){
					  //exit;
					  //}
			 	      
					  //insert to roadweight
			          $sql=sprintf("replace into roadweight(street_id,street_name,weight,lat,lon)values('%s','%s','%s','%s','%s')",
			          $street_id,$street_name,0,$lat,$lon);
			          //echo $sql."<br>";
			          Yii::app()->db->createCommand($sql)->execute();
			       
			          //insert to placeid 
			          $sql=sprintf("replace into placeid(place_id,street_id) values('%s','%s')",$place_id,$street_id);
			          Yii::app()->db->createCommand($sql)->execute();
			          //echo $sql."<br>";
			
			          $street['id']=$street_id;
			          $street['name']=$street_name;
			          $street['weight']=0;		
			          $street['recstate']='new';
					  //echo $street_name."<br>";
		          }
	           }
		   }
		}
		
	    return $street;
    }
	
	public function actionIndex()
	{
	    $mode="device";
		$info=array();
		$time2=time();
		$logs="";		
		$serialgps="";
		$serialgps_snap="";
		$totalweight=0;
		$model=new SearchForm();		
	    if(isset($_REQUEST['deviceid'])){
		   $deviceid=$_REQUEST['deviceid'];
		   $sql=sprintf("select p.deviceTime,p.deviceId,p.latitude,p.longitude,d.name,d.status,d.uniqueId,d.protocol,d.tipe,d.merek from positions p left join devices d on d.id=p.deviceId where p.deviceId='%s' order by p.deviceTime DESC limit 1",$deviceid);
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();
		   if($rs){
			  $info=$rs;
  			  if(isset($rs['deviceTime'])) $time2=strtotime($rs['deviceTime']);
		   }else $info=null;
		   
		   if(isset($_POST['deviceid']) && isset($_POST['date1']) && isset($_POST['date2'])  && !empty($_POST['date1']) && !empty($_POST['date2']) ){
		      //parse date to time		     
			  $dt1=DateTime::createFromFormat('d/m/Y H:i',$_POST['date1']);
              $date1=($dt1==false?time():$dt1->format("U"));
			  $dt2=DateTime::createFromFormat('d/m/Y H:i',$_POST['date2']);
              $date2=($dt2==false?time():$dt2->format("U"));
			  
			  $sql=sprintf("select count(*) from positions where deviceid='%s' and (unix_timestamp(deviceTime) between %d and %d)",$deviceid,$date1,$date2);
			  $count=Yii::app()->db->createCommand($sql)->queryScalar();			  			  
			  
			  //start count
			  $limit=0;
			  $rowcount=10;
			  while($count>0){
			  $delimiter="";
			  $delimiter2="";
			  $serialgps="";
			  
			  $sql=sprintf("select latitude,longitude,deviceTime from positions where deviceid='%s' and (unix_timestamp(deviceTime) between %d and %d) order by deviceTime ASC limit $limit,$rowcount",$deviceid,$date1,$date2);
			  $allgrad=Yii::app()->db->createCommand($sql)->queryAll();
			  $delimiter="";
			  if($allgrad)foreach($allgrad as $row){
			      $serialgps.=$delimiter.$row['latitude'].",".$row['longitude'];
				  $delimiter="|";
			  }
			  if(!empty($serialgps)){
			      $url="https://roads.googleapis.com/v1/snapToRoads?key=".Yii::app()->params['ServerGoogleAPI']."&path=".$serialgps;
				  $road=$this->snap2roads($url);                  
				  $logs.="start calculation...\r\n";
				  $delimiter2="";
				  foreach($road->snappedPoints as $point){
				        if(isset($point->location->latitude) && isset($point->location->longitude)){
						  $serialgps_snap.=$delimiter2.$point->location->latitude.",".$point->location->longitude;
						  $delimiter2="|";
						}
						$street=$this->insertStreet($point->placeId);
						if(!empty($street['recstate'])){
						   if($street['recstate']=='new'){
							 $logs.=sprintf("new.placeId: %s , streetId: %s , streetName: %s , weight: %s\r\n\r\n",$point->placeId,$street['id'],$street['name'],$street['weight'])."\r\n";
						   }else{
							 $logs.=sprintf("old.placeId: %s , streetId: %s , streetName: %s , weight: %s\r\n\r\n",$point->placeId,$street['id'],$street['name'],$street['weight'])."\r\n";
						   }
						   $totalweight+=$street['weight'];
						}
				  }
				  $logs.="totalweight=".$totalweight."\r\n";
				  $logs.="done";
			  }

			  $limit=$limit+$rowcount;
			  $count=$count-$rowcount;
			  }	//end.count
		      
		   }		   
		}
		
		if($info==null){
		  throw new CHttpException(404,'Device does not exist.');		
		}
		
		if(empty($model->date1)) $model->date1=date("d/m/Y H:i",$time2-(3600*24*7));
		if(empty($model->date2)) $model->date2=date("d/m/Y H:i",$time2);
		
	
		$this->render('calculate',array('model'=>$model,'mode'=>$mode,'info'=>$info,'logs'=>$logs,'serialgps_snap'=>$serialgps_snap,'totalweight'=>$totalweight));
		
	}
}
