<?php


/*
if (!isset($_SERVER['HTTP_ORIGIN'])) {
  // This is not cross-domain request
  exit;
}

$wildcard = true; // Set $wildcard to TRUE if you do not plan to check or limit the domains
$credentials = false; // Set $credentials to TRUE if expects credential requests (Cookies, Authentication, SSL certificates)
$allowedOrigins = array('http://otomotifzone.com', 'http://otomotifzone.com/movingbb-backend/gpsemulator/index.php');
if (!in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins) && !$wildcard) {
    // Origin is not allowed
    exit;
}
$origin = $wildcard && !$credentials ? '*' : $_SERVER['HTTP_ORIGIN'];

header("Access-Control-Allow-Origin: " . $origin);
if ($credentials) {
    header("Access-Control-Allow-Credentials: true");
}
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin");
header('P3P: CP="CAO PSA OUR"'); // Makes IE to support cookies

// Handling the Preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { 
    exit;
}

*/


// Connection to postgres
$db=false;
$r=(isset($_REQUEST['r'])?$_REQUEST['r']:'');

if($r=='getscore'){
   $db=new PDO("pgsql:dbname=gis;host=127.0.0.1","postgres","postgres") or die("error db");
   $result=$db->query("SELECT sum(score) as mscore from banner_route where device_id=4");
   $score=0;
   if($result!=null){
    $row=$result->fetch(PDO::FETCH_NUM);
    $score=$row[0];
   }
   $road=array();
   $sql="select osm_id,name,checkin_time from banner_route where device_id=4 limit 10";
   $result=$db->query($sql);
   while($row=$result->fetch(PDO::FETCH_NUM)){
     $road[]=array('osm_id'=>$row[0],'name'=>$row[1]);
   }
   $db=null;

   header("Content-Type: application/json; charset=utf-8");
   echo json_encode(array('status' => 'OK','score'=>$score,'road'=>$road));
   exit;

}else{

  // Connection to postgres
  if($db===false) $db=new PDO("pgsql:dbname=gis;host=127.0.0.1","postgres","postgres") or die("error db");

  $lat=(isset($_REQUEST['lat'])?$_REQUEST['lat']:0);
  $lon=(isset($_REQUEST['lon'])?$_REQUEST['lon']:0);
  $sql=sprintf("insert into positions(protocol,deviceid,servertime,devicetime,fixtime,valid,latitude,longitude,altitude,speed,course,attributes)".
  " select 'osmand',4,now()::timestamp,now()::timestamp,now()::timestamp,false,%f,%f,0,0,0,''",$lat,$lon);
  $db->query($sql);

  echo $sql.";\n";

  $db=null;

  //Response
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode(array('status' => 'OK','time'=>time()));

}


?>
