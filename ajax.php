<?php

include('config.php');

$method = optional_param('m');

switch ($method) {
	case 'tweet':
		saveTweet(optional_param('text'));
		break;

	case 'follow':
		addFollower(optional_param('userid'));
		break;

	case 'unfollow':
		removeFollower(optional_param('userid'));
		break;
	
	default:
		# code...
		break;
}

function saveTweet($message)
{
	$tweets = R::dispense('tweets');

	$tweets->userid     = $_SESSION['user_id'];
	$tweets->tweets 	= $message;

	$id = R::store($tweets);
}

function addFollower($userid)
{
	$following = R::dispense('following');

	$following->userid     = $_SESSION['user_id'];
	$following->follows 	= $userid;

	$id = R::store($following);
}

function removeFollower($userid)
{
	$following = R::findOne('following','userid = ? AND follows = ?', array($_SESSION['user_id'],$userid));
	//R::trash($following);
}

?>