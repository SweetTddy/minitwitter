<?php
	unset($CFG);

	$CFG = new stdClass();

	$CFG->dbhost		= 'localhost';
	$CFG->dbusername	= 'root';
	$CFG->dbpassword	= 'root';
	$CFG->dbname		= 'miniTwitter';

	$CFG->siteroot 		= 'http://localhost/PMS/minitwitter/';
	$CFG->dataroot 		= 'E:/xampp/htdocs/PMS/minitwitter/upload';

	$CFG->status		= 'dev';

	require 'rb.php';	
	R::setup("mysql:host=$CFG->dbhost;dbname=$CFG->dbname","$CFG->dbusername","$CFG->dbpassword");

	require_once('lib.php');
?>