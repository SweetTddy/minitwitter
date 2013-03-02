<?php

if(!empty($_POST))
{
	print_object($_POST);

	$user_details = R::findOne('user',' email = ? AND password = ?', array(optional_param('email'), optional_param('password')));

  if (isset($user_details->id))
  {
      $user['id']             = $user_details->id;
      $user['twitter_name']   = $user_details->twitter_name;
      $user['fullname']       = $user_details->fullname;
      $user['email']          = $user_details->email;

      set_session_cookie($user);

      redirect('index.php');
  }
  else
  {
    redirect('index.php?p=login&m=invalid-login');
  } 
}

?>

<div class="container">

  <form class="form-signin" id="login" method="post" action="index.php?p=login">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="text" class="input-block-level validate[required,custom[email]]" name="email" placeholder="Email address">
    <input type="password" class="input-block-level validate[required]" name="password" placeholder="Password">    
    <button class="btn btn-large btn-primary" type="submit">Sign in</button>

    <hr/>

    <h2 class="form-signin-heading">New User?</h2>
    <a href="index.php?p=signup" class="btn btn-large btn-primary">Sign Up</a>
  </form>

</div> <!-- /container -->

<script>
$(document).ready(function() {
  $("#login").validationEngine();
});
</script>