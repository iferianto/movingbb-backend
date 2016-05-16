<?php

class CalculatebannerController extends Controller
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


        /**
        fix query timeout to googleapis
        now we using our  internal maps postgresql database imported from OSM 
        for finding streetname
        */

	public function actionIndex()
	{
		$mode="device";
		$info=array();
		$time2=time();
		$logs="";
		$serialgps="";
		$serialgps_snap="";
		$totalscore=0;
                $alert="";
		$model=new SearchForm();
                $passroad=array();

		if(isset($_REQUEST['deviceid'])){
		   $deviceid=$_REQUEST['deviceid'];
		   $sql=sprintf("select * from devices where id='%s'",$deviceid);
		   $rs=Yii::app()->db->createCommand($sql)->queryRow();


		   if($rs){
		      $info=$rs;
                      $sql=sprintf("select max(devicetime) from positions where deviceid='%s'",$deviceid);
                      $t0=Yii::app()->db->createCommand($sql)->queryScalar();
                      $dt0=DateTime::createFromFormat('Y-m-d H:i:s',$t0);
                      $time2=($dt0==false?time():$dt0->format("U"));
		   }else{
                      $info=null;
                   }



		   if(isset($_POST['deviceid']) && isset($_POST['date1']) && isset($_POST['date2'])  && !empty($_POST['date1']) && !empty($_POST['date2']) ){

 		          //parse date to time
			  $dt1=DateTime::createFromFormat('d/m/Y H:i',$_POST['date1']);
                          $date1=($dt1==false?time():$dt1->format("U"));
			  $dt2=DateTime::createFromFormat('d/m/Y H:i',$_POST['date2']);
                          $date2=($dt2==false?time():$dt2->format("U"));


                          //check maxdatediff , mustbe under 7 days
                          $dDiff = $dt1->diff($dt2);
                          
			  if(abs($dDiff->days) > 6 ){
                             $alert="Range date mustbe under 7";
                          }else{
                             //sum score
                             $sql=sprintf("select sum(COALESCE(r.score,0)) from banner_route r".
                             " where r.device_id=%d and (EXTRACT(epoch FROM r.checkin_time) between %d and %d)",$deviceid,$date1,$date2);
                             $totalscore=Yii::app()->db->createCommand($sql)->queryScalar();


                             //get all street
                             $sql=sprintf("select r.id,r.device_id,r.osm_id,r.name,r.checkin_time,COALESCE(r.score,0) as score,".
                             "r.latitude,r.longitude from banner_route r".
                             " where r.device_id=%d and (EXTRACT(epoch FROM r.checkin_time) between %d and %d)",$deviceid,$date1,$date2);
                             $allgrad=Yii::app()->db->createCommand($sql)->queryAll();
                             if($allgrad) foreach($allgrad as $row){
                               $passroad[$row['id']]=$row;
	                     } //end.foreach

                             

                           } //end.lebih dari 5




                   } //end.postvar




		} //end isset deviceid

		if($info==null){
		  throw new CHttpException(404,'Device does not exist.');
		}


		if(empty($model->date1)) $model->date1=date("d/m/Y H:i",$time2-(3600*24*5));
		if(empty($model->date2)) $model->date2=date("d/m/Y H:i",$time2);


		$this->render('calculate',array('model'=>$model,'mode'=>$mode,'info'=>$info,
                'logs'=>$logs,'serialgps_snap'=>$serialgps_snap,'totalscore'=>$totalscore,
                'alert'=>$alert,'passroad'=>$passroad));


	}



}
