<html>
<head>
<title>Map Routing - Moving Banner Earning Calculation</title>
<style>
html,body{height:100%;margin:0;padding:0;font-family:arial}
#row1{float:left;clear:both}
#map-canvas{height:500px;width: 500px;float:left;}
#logs{float:left;width:300px;height:500px;background:#eee}
#logcontent{float:left;width:300px;height:480px;overflow:scroll;
white-space:pre;display:block;
line-height:1.2rem;counter-reset:line;
font-size:10px;font-family:courier;}
#logcontent span:before{counter-increment: line;
content:counter(line);
display:inline-block;
border-right:1px solid #ddd;
padding:0 .2em;
margin-right:.5em;color:#888;}
#nav{height:50px;padding:5px}
#mapErrorMsg{position:absolute;top:10px;left:10px;
background:#fff;z-index:1000;width:500px;height:500px;visibility:hidden}
#btnGetscore{visibility:visible;background:#555500;color:#ffffff}
#btnsimulate{background:red}
#scorediv{
z-index:1000;
position:absolute;
top:60px;left:830px;
width:150px;height:50px;background:#ffff00;color:#000;
padding:20px;font-size:20px;font-weight:bold;
border:2px #000 solid;
}
#roaddiv{
visibility:visible;
z-index:1000;
position:absolute;
top:180px;left:830px;
width:400px;height:300px;background:#fff;color:#000;
padding:20px;font-size:12px;font-weight:normal;
border:2px #000 solid;
overflow:scroll
}
</style>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
var marker,markerA,markerB,pointA,pointB;
var directionsService;
var directionsDisplay;
var myInfoWindow;
var map;
var route;
function initMap() {
    pointA = new google.maps.LatLng(-6.23827,106.76509);
    pointB = new google.maps.LatLng(-6.22952,106.76213);
	myInfoWindow = new google.maps.InfoWindow();
    myOptions = {
      zoom: 15,
      center: pointA
    },
    map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);
    // Instantiate a directions service.
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer({
      map: map
    });	
	
    markerA = new google.maps.Marker({
      position: pointA,
      title: "point A",
      label: "A",
      map: map,
	  draggable: true,
    });
    markerB = new google.maps.Marker({
      position: pointB,
      title: "point B",
      label: "B",
      map: map,
	  draggable: true,
    });
	
	google.maps.event.addListener(markerA, 'dragend', function(evt){
		geocodePosition(this.getPosition());
		pointA = evt.latLng;
		clearDirectionDisplay();
	});
	google.maps.event.addListener(markerB, 'dragend', function(evt){
		geocodePosition(this.getPosition());
		pointB = evt.latLng;
		clearDirectionDisplay();
	});	
	google.maps.event.addListener(markerA, "click", function(evt) {
	    var html='<b>Location:</b><br>'+
		'Lat : ' + evt.latLng.lat().toFixed(5) + '<br>'+
		'Lon : ' + evt.latLng.lng().toFixed(5) ;	
		myInfoWindow.setContent(html);
		myInfoWindow.open(this.getMap(), this);
	});
}

function clearDirectionDisplay(){
 if(marker)marker.setMap(null);
 if(directionsDisplay)directionsDisplay.setMap(null);
 if(route)route.setMap(null);
}

function moveMarker(mymap, mymarker, latlng) {
 mymarker.setPosition(latlng);
 mymap.panTo(latlng);
}

function autoRefresh(map, pathCoords) {
    var i;    
    route = new google.maps.Polyline({
        path: [],
        geodesic : true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2,
        editable: false,
        map:map
    });    
    marker=new google.maps.Marker({map:map,
	icon:"http://maps.google.com/mapfiles/ms/micons/blue.png"});
    for (i = 0; i < pathCoords.length; i++){
        setTimeout(function(coords) {
            route.getPath().push(coords);			
            moveMarker(map, marker, coords);			
			jQuery("#logcontent").append("<span class=\"line\">Move to: "+coords.lat()+
			","+coords.lng()+"</span>\n");		
            sendToserver(coords.lat(),coords.lng);			
        }, 200 * i, pathCoords[i]);
    }
	$('#btnSimulate').prop('disabled',false);
}

function sendToserver(lat,lon){
$.ajax({
  type: 'POST',
  url: 'http://otomotifzone.com/movingbb-backend/gpsemulator/api/index.php?r=receivelog/post',
  data: {lat:lat,lon:lon},
  success:function(){},
  dataType:'json',
  async:false
});
}

function animateStraighLine(){
 var departure = pointA;
 var arrival =pointB;
 var line = new google.maps.Polyline({
      path: [departure, departure],
      strokeColor: "#FF0000",
      strokeOpacity: 1,
      strokeWeight: 1,
      geodesic: true, //set to false if you want straight line instead of arc
      map: map,
 });
 var step = 0;
 var numSteps = 250; //Change this to set animation resolution
 var timePerStep = 5; //Change this to alter animation speed
 var interval = setInterval(function() {
     step += 1;
     if (step > numSteps) {
         clearInterval(interval);
     } else {
         var are_we_there_yet = google.maps.geometry.spherical.interpolate(departure,arrival,step/numSteps);
         line.setPath([departure, are_we_there_yet]);
     }
 },timePerStep);
}

function routing(){
	calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB){
  var request = {
        origin: pointA,
        destination: pointB,
        travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}




function geocodePosition(pos) 
{
   geocoder = new google.maps.Geocoder();
   geocoder.geocode
    ({
        latLng: pos
    }, 
        function(results, status) 
        {
            if (status == google.maps.GeocoderStatus.OK) 
            {
				
                $("#mapSearchInput").val(results[0].formatted_address);
                $("#mapErrorMsg").hide(100);
            } 
            else 
            {
				$("#mapErrorMsg").show();
                $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        }
    );
}

function getscore(){
 $.ajax({
  type: 'GET',
  url: 'http://otomotifzone.com/maps/api/index.php?r=getscore',  
  success:function(data){
     if(data.score) $("#scorediv").html("Earn Score:<br><font color=red style=\"font-size:30px\">"+data.score+"</font>");
	 if(data.road){
	    $("#roaddiv").html("<b>Road track today:</b><br>");
		for(i=0;i<data.road.length;i++){
		   var row=data.road[i];
		   $("#roaddiv").append("- "+row.name+"<br>");
		}
	    
	 }
  },
  dataType:'json',
  async:false
});
 scorediv
}

function simulate(){
   $('#btnSimulate').prop('disabled', true);
    var request = {
        origin: pointA,
        destination: pointB,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, 
	function(response, status) {


        if (status == google.maps.DirectionsStatus.OK) {
            autoRefresh(map, response.routes[0].overview_path);
        }
    });
	
	$('#btnGetscore').css('visibility', 'visible');
}

function addlinenumber(){
 jQuery("#logcontent").html(function(index, html) {
   return html.replace(/^(.*)$/mg, "<span class=\"line\">$1</span>")
 });
}
function clearlog(){
 jQuery("#logcontent").html("");
 clearDirectionDisplay();
}

$( document ).ready(function() {
  //addlinenumber();	
});
</script>
<body onload="initMap()">
<div id="nav">
Routing procedure will draw routing direction from A to B, simulate will act as GPS traccker for that route<br>
<input type="button" id="btnRouting" onclick="routing()" value="calc routing"/>
<input type="button" id="btnSimulate" onclick="simulate()" value="simulate gps tracker"/>
<input type="button" id="btnClearlog" onclick="clearlog()" value="clearlog"/>
<input type="text" id="mapSearchInput" placeholder="Location of point A draggend" style="width:450px"/>
<input type="button" id="btnGetscore" onclick="getscore()" value="show score"/>
</div>
<div id="row1">
<div id="map-canvas"></div>
<div id="logs">Logs Window:<br>
<div id="logcontent"></div>
</div>



</div>
<div id="mapErrorMsg"></div>
<div id="scorediv">Score:<br>0</div>
<div id="roaddiv">Road track</div>

</body>
</html>
