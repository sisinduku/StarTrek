<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>StarTrek - <?php echo $pageTitle; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url("/assets/bower_components/bootstrap/dist/css/bootstrap.min.css");?>" rel="stylesheet">

    <!-- DataTables Bootstrap CSS -->
    <link href="<?php echo base_url("/assets/css/dataTables.bootstrap.css");?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url("/assets/dist/css/sb-admin-2.css");?>" rel="stylesheet">

    <!-- Morris Charts CSS -->
    

    <!-- Custom Fonts -->
    <link href="<?php echo base_url("/assets/bower_components/font-awesome/css/font-awesome.min.css");?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
		<div class="blank-background">
			
		</div>
        <!-- Navigation -->
        <button class="btn btn-default float-menu">
        	<span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
        
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url("/main");?>">STARTREK (System Early Warning dan Monitoring Perangkat WiFi)</a>
            </div>
            <!-- /.navbar-header -->
			
			<!--  .navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
            	<li>
            		<p><strong><?php echo $this->session->username;?></strong></p>
            	</li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url("/login/logout")?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
			<!-- .navbar-static-side -->
			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo site_url("/main"); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> NMS API <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://localhost/startrek/index.php/main/lihat_api/ap">Access Point</a>
                                </li>
                                <li>
                                    <a href="#">Alarm (Coming Soon)</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Menu 3</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Menu 4</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Menu 5<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Sub Menu 5.1</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 5.2</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 5.3</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 5.4</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 5.5</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 5.6</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Menu 6<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Sub Menu 6.1</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 6.2</a>
                                </li>
                                <li>
                                    <a href="#">Sub Menu 6.3 <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Sub Menu 6.3.1</a>
                                        </li>
                                        <li>
                                            <a href="#">Sub Menu 6.3.2</a>
                                        </li>
                                        <li>
                                            <a href="#">Sub Menu 6.3.3</a>
                                        </li>
                                        <li>
                                            <a href="#">Sub Menu 6.3.4</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i>Sub Menu 7<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Sub Menu 7.1</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>