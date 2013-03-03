<?php

include('config.php');
include('header.php');

require_once 'Faker/src/autoload.php';

$faker = Faker\Factory::create();

$i = 1;

do{

	$user = R::dispense('user');
    
    $user->fullname     = $faker->name;
    $user->email        = $faker->email;
    $user->password     = $faker->username;
    $user->twitter_name = $faker->username;
    $user->bio          = $faker->text;
    $user->image        = '';

    $uid = R::store($user);

    $j = 1;

    do{
    	$tweets = R::dispense('tweets');
		$tweets->userid	= $uid;
    	$tweets->tweets = $faker->text;
		R::store($tweets);
    }
    while($j++ < 1);

    

}
while($i++ < 10);

$following = R::dispense('following');
$following->userid  = 1;
$following->follows = 2;
$id = R::store($following);

echo '<div class="container"><h3>Tadaa !! Fake Data Generated.</h3></div>';

include('footer.php');

?>