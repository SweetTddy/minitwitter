<?php
if(isLogin(false))
{
?>

<div class="container">
	<?php require('guest.php') ?>
</div>

<?php
}
else
{
?>
<div class="container">
	<?php require('user.php') ?>
</div>
<?php
}
?>