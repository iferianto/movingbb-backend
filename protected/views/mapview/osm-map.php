<style>
.widget-body,.span-19{padding:0px;margin:0px}
.blue{color:#0000ff}
.firstHeading{border-bottom:4px #999 solid;font-size:20px;color:#000;margin:0px;padding:0px}
.mh3{border-bottom:4px #999 solid;font-size:18px;color:blue;margin:0px;padding:0px}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/js/openlayer/v3.14.2/css/ol.css"/>
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/openlayer/v3.14.2/build/ol.js"></script>
<script type="text/javascript">
var map;
var infowindow;
var marker;
var iconGeometry;
/*
var device_name="<?php if(isset($info['name'])) echo $info['name'];else echo "Unknown Object";?>";
<?php 
if(isset($info['latitude']) && isset($info['longitude'])) echo "var mapCenter = new google.maps.LatLng(".$info['latitude'].",".$info['longitude'].");";
else echo "var mapCenter = new google.maps.LatLng(47.6145, -122.3418);";
?>
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

*/
function map_initialize(){
/*
    map = new OpenLayers.Map("map");
        var mapnik         = new OpenLayers.Layer.OSM();
        var fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        var toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
        var position       = new OpenLayers.LonLat(13.41,52.52).transform( fromProjection, toProjection);
        var zoom           = 15;

        map.addLayer(mapnik);
        map.setCenter(position, zoom );
*/
// var fromProjection=new ol.Projection("EPSG:4326");   // Transform from WGS 1984
// alert(fromProjection);
//  var toProjection   = new ol.Projection("EPSG:900913"); // to Spherical Mercator Projection
//  var position       = new ol.LonLat(13.41,52.52).transform( fromProjection, toProjection);

 var map_center = ol.proj.transform([<?php echo $info['longitude'];?>,<?php echo $info['latitude'];?>],'EPSG:4326','EPSG:900913');
 var map_zoom=18;
 var iconGeometry=new ol.geom.Point(map_center);
 var iconFeature = new ol.Feature({
  geometry:iconGeometry,
  name: 'Null Island',
  population: 4000,
  rainfall: 500
 });

 var iconStyle = new ol.style.Style({
  image: new ol.style.Icon(({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 0.75,
    src: 'images/iconred.png'
  }))
 });
 iconFeature.setStyle(iconStyle);

 var vectorSource = new ol.source.Vector({features:[iconFeature]});
 var vectorLayer = new ol.layer.Vector({source:vectorSource});

 map=new ol.Map({layers:[new ol.layer.Tile({source:new ol.source.OSM()}),vectorLayer],
 target:'map',view:new ol.View({center:map_center,rotation:0,zoom:map_zoom})});

 $('.ol-zoom-in, .ol-zoom-out').tooltip({placement:'right'});
 $('.ol-rotate-reset, .ol-attribution button[title]').tooltip({placement:'left'});

 map.on('singleclick', function (evt) {
   //iconGeometry.setCoordinates(evt.coordinate);
 });

 //var geolocation = new ol.Geolocation({tracking:false});
 //geolocation.bindTo('projection', map.getView());
}
$(document).ready(function() {
  $("#map").width($("#content").width());
  $("#map").height($("#content").height()+100);
  map_initialize();
});
</script>
<div id="map" style="width:700px;height:500px"></div>
