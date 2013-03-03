<?php

if(isLogin(false))
{
	require('guest.php');
}
else
{
	require('wall.php');
}

?>