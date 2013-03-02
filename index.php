<?php
  include('config.php');
  include('header.php');

  $page = optional_param('p');


  switch ($page) {
  	case 'login':
  		$page_type = 'login';
  		break;

  	case 'signup':
  		$page_type = 'signup';
  		break;
  	
  	default:
  		$page_type = 'home';
  		break;
  }

  include $page_type.'.php';

  include('footer.php');
?>