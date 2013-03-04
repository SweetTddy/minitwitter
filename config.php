<?php

	error_reporting(E_ALL);

	unset($CFG);

	$CFG = new stdClass();

	$CFG->dbhost		= 'us-cdbr-east-03.cleardb.com';
	$CFG->dbusername	= 'b71737066fc0bf';
	$CFG->dbpassword	= '5637a063';
	$CFG->dbname		= 'heroku_9ea0cd79e460055';

	/*
	$CFG->dbhost		= 'localhost';
	$CFG->dbusername	= 'root';
	$CFG->dbpassword	= 'root';
	$CFG->dbname		= 'minitwitter';
	*/

	$CFG->siteroot 		= 'http://robin-flyhigh-mini-twitter.herokuapp.com/';
	$CFG->dataroot 		= '/app/www/uploads';

	require 'rb.php';	
	R::setup("mysql:host=$CFG->dbhost;dbname=$CFG->dbname","$CFG->dbusername","$CFG->dbpassword");

	require_once('lib.php');
?>