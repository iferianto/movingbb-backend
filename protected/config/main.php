<?php

date_default_timezone_set('Asia/Jakarta');
//$localIP = getHostByName(getHostName());
//if(!($localIP=='192.168.200.119' || $localIP=='192.168.2.80')) die("maaf lisensi 2.0 tidak teridentifikasi");
/*$server_name=exec('hostname');
if($server_name!="x11r6" && $server_name!='simpeg') die("maaf lisensi 2.1 tidak teridentifikasi");
$tm=strtotime('2015-05-18');
if(time()>$tm)die("program exit code 5, please contact vendor");
*/
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('PHPExcel', dirname(__FILE__) . '/../vendors/PHPExcel');
Yii::setPathOfAlias('PHPExcelIO', dirname(__FILE__) . '/../vendors/PHPExcel/PHPExcel');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'MovingBB',
	'theme'=>'adminlab',
	'language'=>'id',
	// preloading 'log' component
	'preload'=>array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.1.*','::1','*'),
		),

	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		
		'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
           // GD or ImageMagick
          'driver'=>'GD',
           // ImageMagick setup path
           //'params'=>array('directory'=>'/opt/local/bin'),
        ),     
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'ServerGoogleAPI'=>"AIzaSyDrlTRMCChZ6b9fhgLjDun-kpeSO2xo41o",
		'BrowserGoogleAPI'=>"AIzaSyDC5yU4VaL5O6DrxDaTM0001eRo4F6CPro",
		'adminEmail'=>'webmaster@example.com',
	),
);