<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo Yii::app()->name;?></title>
		
<!--Declare page as mobile friendly --> 
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
<!-- Declare page as iDevice WebApp friendly -->
<meta name="apple-mobile-web-app-capable" content="yes"/>
<!-- iDevice WebApp Splash Screen, Regular Icon, iPhone, iPad, iPod Retina Icons -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/splash/splash-icon.png"> 
<!-- iPhone 3, 3Gs -->
<link rel="apple-touch-startup-image" href="images/splash/splash-screen.png" 			media="screen and (max-device-width: 320px)" /> 
<!-- iPhone 4 -->
<link rel="apple-touch-startup-image" href="images/splash/splash-screen@2x.png" 		media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" /> 
<!-- iPhone 5 -->
<link rel="apple-touch-startup-image" sizes="640x1096" href="images/splash/splash-screen@3x.png" />
<!--end mobile-->	
		
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/css/style.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/css/style_responsive.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/css/style_default.css" rel="stylesheet" id="style_color" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>		
    </head>

    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="fixed-top">
        <!-- BEGIN HEADER -->
        <div id="header" class="navbar navbar-inverse">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="navbar-inner">
                <div class="container-fluid">

                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="arrow"></span>
                    </a>
				
                    <!-- BEGIN LOGO -->
                    <a class="brand" href="<?php echo Yii::app()->baseUrl; ?>">
                        <font size="5" color="white" ><?php echo Yii::app()->name;?></font>
                    </a>
                    <!-- END LOGO -->
					
                    <div class="top-nav ">
                        <ul class="nav pull-right top-menu" >
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/avatar1_small.jpg" alt="">
                                    <span class="username"><?php 
									if(isset(Yii::app()->session['nama_user'])) echo Yii::app()->session['nama_user'];
									else echo Yii::app()->user->name; ?></span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo Yii::app()->createUrl('biodata');?>"><i class="icon-user"></i> My Profile</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo Yii::app()->createUrl('site/logout');?>"><i class="icon-key"></i> Log Out</a></li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
		
        <!-- BEGIN CONTAINER -->
        <div id="container" class="row-fluid">
            <!-- BEGIN SIDEBAR -->
            <div id="sidebar" class="nav-collapse collapse">
                <div class="sidebar-toggler hidden-phone"></div>   

                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                <!-- BEGIN SIDEBAR MENU -->
                <ul class="sidebar-menu">

                    
					
<li><a class="" href="<?php echo Yii::app()->createUrl('/users'); ?>"><span class="icon-box"><i class="icon-user"></i></span> Operator</a></li>
<li><a class="" href="<?php echo Yii::app()->createUrl('/devices'); ?>"><span class="icon-box"><i class="icon-film"></i></span> Devices</a></li>
<li><a class="" href="<?php echo Yii::app()->createUrl('/roadweight'); ?>"><span class="icon-box"><i class="icon-tags"></i></span> Road Weight</a></li>
<li><a class="" href="<?php echo Yii::app()->createUrl('/mapview'); ?>"><span class="icon-box"><i class="icon-move"></i></span> Maps</a></li> 
<li><a class="" href="http://www.otomotifzone.com/movingbb-backend/gpsemulator" target="_blank"><span class="icon-box"><i class="icon-move"></i></span> GPS Emulator</a></li>



										
<li><a class="" href="<?php echo Yii::app()->createUrl('site/logout')?>"><span class="icon-box"><i class="icon-key"></i></span> Logout</a></li>
</ul>
<!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
			
			
            <!-- BEGIN PAGE -->  
            <div id="main-content">
                    <!-- BEGIN PAGE CONTENT-->
                            <div class="widget">
                                <div class="widget-title">
                                    <h4><i class="icon-globe"></i><?php echo  $this->getUniqueId();?></h4>
                                    <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                    </span>                    
                                </div>
                                <div class="widget-body">
                                    <?php echo $content; ?>
                                </div>
                            </div>					
					
			
            </div>
            <!-- END PAGE -->  
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div id="footer">
            2015 &copy;
            <div class="span pull-right">
                <span class="go-top"><i class="icon-arrow-up"></i></span>
            </div>
        </div>
        <!-- END FOOTER -->
		
		<!-- BEGIN JAVASCRIPTS -->    
        <!-- Load javascripts at bottom, this will reduce page load time -->
        <!--script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/js/jquery-1.8.3.min.js" type="text/javascript"></script-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/js/jquery.blockui.js" type="text/javascript"></script>
        <!-- ie8 fixes -->
        <!--[if lt IE 9]>
        <script src="js/excanvas.js"></script>
        <script src="js/respond.js"></script>
        <![endif]-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/chosen-bootstrap/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/adminlab/asset2/js/scripts.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function() {
                // initiate layout and plugins
                App.init();
            });
        </script>
  
    </body>
    <!-- END BODY -->
</html>
