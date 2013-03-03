<?php
	unset($CFG);

	$CFG = new stdClass();

	$CFG->dbhost		= 'localhost';
	$CFG->dbusername	= 'b71737066fc0bf';
	$CFG->dbpassword	= '5637a063';
	$CFG->dbname		= 'heroku_9ea0cd79e460055';

	$CFG->siteroot 		= 'http://robin-flyhigh-mini-twitter.herokuapp.com/';
	$CFG->dataroot 		= 'E:/xampp/htdocs/PMS/minitwitter/uploads';

	require 'rb.php';	
	R::setup("mysql:host=$CFG->dbhost;dbname=$CFG->dbname","$CFG->dbusername","$CFG->dbpassword");

	require_once('lib.php');
?>