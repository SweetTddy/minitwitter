<?php

if(isLogin(false))
{
	require('guest.php');
}
else
{
	require('user.php');
}

?>