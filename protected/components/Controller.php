<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
}


function LOG_POSTDATA(){
		$data="";
		if(isset($_POST)){
			foreach($_POST as $key=>$val){
				$data.=$key."=".$val."\n";
			}
			$fp=fopen("data.txt","w+");
			fwrite($fp,$data);
			fclose($fp);
		}
}



function Get_Address_From_Google_Maps($lat, $lon) {

$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";

// Make the HTTP request
$data = @file_get_contents($url);
// Parse the json response
$jsondata = json_decode($data,true);

// If the json data is invalid, return empty array
if (!check_status($jsondata))   return array();

$address = array(
    'country' => google_getCountry($jsondata),
    'province' => google_getProvince($jsondata),
    'city' => google_getCity($jsondata),
    'street' => google_getStreet($jsondata),
    'postal_code' => google_getPostalCode($jsondata),
    'country_code' => google_getCountryCode($jsondata),
    'formatted_address' => google_getAddress($jsondata),
);

return $address;
}

/* 
* Check if the json data from Google Geo is valid 
*/

function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

/*
* Given Google Geocode json, return the value in the specified element of the array
*/

function google_getCountry($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata) {
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata) {
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata) {
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata) {
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

/*
* Searching in Google Geo json, return the long name given the type. 
* (If short_name is true, return short name)
*/

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach( $array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)    
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}


function searchlocationbylatlon($gps_lat,$gps_lon){
	
	  $sql="SELECT id, ( 3959 * acos( cos( radians(".$gps_lat.") ) * cos( radians( lat ) ) * 
	  cos( radians( lng ) - 
	  radians(-122) ) + sin( radians(".$gps_lon.") ) * sin( radians( lat ) ) ) ) AS 
	  distance FROM markers 
	  HAVING distance < 25 ORDER BY distance LIMIT 0 , 20";
	  
	  
}
