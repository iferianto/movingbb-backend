<style>
.widget-body,.span-19{padding:0px;margin:0px}
.blue{color:#0000ff}
.firstHeading{border-bottom:4px #999 solid;font-size:20px;color:#000;margin:0px;padding:0px}
.mh3{border-bottom:4px #999 solid;font-size:18px;color:blue;margin:0px;padding:0px}
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?php echo Yii::app()->params['BrowserGoogleAPI'];?>&sensor=false"></script>
<script type="text/javascript">
var device_name="<?php if(isset($info['name'])) echo $info['name'];else echo "Unknown Object";?>";
<?php 
if(isset($info['latitude']) && isset($info['longitude'])) echo "var mapCenter = new google.maps.LatLng(".$info['latitude'].",".$info['longitude'].");";
else echo "var mapCenter = new google.maps.LatLng(47.6145, -122.3418);";
?>
var map;
var infowindow;
var marker;
function getDeviceInfo(m){
var latLng=m.position;
var gps_lat=latLng.lat();
var gps_lon=latLng.lng();
var extended_info="<?php
if(isset($info)){
 foreach($info as $key=>$val){
   if(preg_match('/latitude|longitude|deviceid/',$key)) continue;
   echo $key." : <span class=\'blue\'>".$val."</span><br>";
 }
}
?>";
var deviceid="<?php if(isset($info['deviceid'])) echo $info['deviceid'];?>";
var contentString='<div id="content">'+
      '<h1 class="firstHeading">#'+device_name+'</h1>'+
      '<div id="bodyContent">'+
      '<p>Device Location Based On Last Position Received:</p>'+
	  '<p>Lat : <b class="blue">'+gps_lat+'</b> , Lon: <b class="blue">'+gps_lon+'</b></p>'+
	  '<p><h3 class="mh3">Extended Info:</h3></p>'+
	  '<p>'+extended_info+'</p>'+
      <?php if(isset($info['type']) && $info['type']=='device') echo "'<p><input type=button value=\"calculate\" onclick=\"calculatebannerval('+deviceid+')\"></p>'+"; ?>
      '</div>'+
      '</div>';
return contentString;	  
}	

function calculatebannerval(id){
  var baselocation="<?php echo Yii::app()->createUrl('calculatebanner',array('deviceid'=>'xxx'));?>";
  document.location=baselocation.replace("xxx",id);
}  

function map_initialize(){
    //Google map option
    var googleMapOptions =
    {
        center: mapCenter, // map center
        zoom:18, //zoom level, 0 = earth view to higher value
        panControl: true, //enable pan Control
        zoomControl: true, //enable zoom control
        zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL //zoom control size
        },
        scaleControl: true, // enable scale control
        mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
  };
  map=new google.maps.Map(document.getElementById("google_map"), googleMapOptions);   
  infowindow=new google.maps.InfoWindow({content:'.....'});
  marker=new google.maps.Marker({
    position: mapCenter,
    map: map,
    draggable:true,animation: google.maps.Animation.DROP,
    title: 'Device Location'
  });
  google.maps.event.addListener(marker, "click", function (event) {
    infowindow.setContent(getDeviceInfo(this));
    infowindow.open(map, this);	
  });
   
}
$(document).ready(function() {
  $("#google_map").width($("#content").width());
  $("#google_map").height($("#content").height()+100);
  map_initialize();
});
</script>
<div id="google_map" style="width:700px;height:500px"></div>
