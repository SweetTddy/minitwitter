<?php

include('config.php');
include('header.php');
?>

<div class="container-narrow">

<table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Password</th>
                </tr>
              </thead>
              <tbody>

<?php

    $users = R::findAll('user');

    foreach ($users as $key => $u) {
        echo '<tr><td>'.$u->id.'</td><td>'.$u->fullname.'</td><td>'.$u->twitter_name.'</td><td>'.$u->email.'</td><td>'.$u->password.'</td></tr>';
    }    
?>            
              </tbody>
            </table>

</div> <!-- /container -->

<?php
include('footer.php');
?>