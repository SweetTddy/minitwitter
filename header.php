<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>mini Twitter </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="docs/assets/css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <script src="docs/assets/js/jquery.js"></script>

    <link href="docs/assets/css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="css/validationEngine.jquery.css" rel="stylesheet">
    <link href="css/colorbox.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="docs/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="docs/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="docs/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="docs/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="docs/assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="docs/assets/ico/favicon.png">
  </head>

  <body>

	<div id="wrap">

		<div class="navbar navbar-navbar-fixed-top">

			<div class="btn-group pull-right">
				<a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
				<?php
				if(islogin(false))
				{
				?>
					<i class="icon-user"></i> Hello Wonder
				<?php
				}
				else
				{
				?>
					<i class="icon-user"></i> Hello <?php echo $_SESSION['fullname'];?>
				<?php
					}
				?>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">

					<?php 
					if(!islogin(false))
					{
					?>
						<li><a href="index.php?p=profile">Profile</a></li>
						<li class="divider"></li>
					    <li><a href="logout.php">Sign Out</a></li>
						    
					<?php
					}
					else
					{
					?>
						<li><a href="index.php?p=login">Login</a></li>
						<li><a href="index.php?p=signup">Signup</a></li>						
					<?php
					}
					?>					
				</ul>
			</div>

		  <div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="brand" href="#">mini Twitter</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li><a href="index.php">Home</a></li>
				  <li><a role="button" data-toggle="modal" href="#about">About</a></li>
				  <li><a role="button" data-toggle="modal" href="#contact">Contact</a></li>             
				  <li><a role="button" href="fake.php">Generate Fake Data</a></li>             
				  <li><a role="button" href="user-data.php">Username & Password</a></li>             
				</ul>            
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</div>
    