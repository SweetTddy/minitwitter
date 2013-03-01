<?php
  include('header.php');
?>

<?php

if($_SESSION['login']=='true')
{
  include('home.php');
}
else
{
  include('home.php');
}

?>


<?php
  include('footer.php');
?>