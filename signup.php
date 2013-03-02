<?php

if(!empty($_POST))
{

  $master_image_path = "users";

  $size[] = array('width' => 160 , 'height' => 120);
  $size[] = array('width' => 500 , 'height' => 500);

  $target_path = $CFG->dataroot."/$master_image_path/";
  if(!file_exists($target_path)){
    mkdir($CFG->dataroot."/$master_image_path",0755,true);
  }

  if(optional_param('submit') == 'Register')
  {
      if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
      {
        $image = upload_image('image',$target_path,$size);      
        if($image)
          $image = $image;
        else
        $image = '';
      }


      $user = R::dispense('user');
    
      $user->fullname     = optional_param('fullname');
      $user->email        = optional_param('email');
      $user->password     = optional_param('password');
      $user->twitter_name = optional_param('twitter_name');
      $user->bio          = optional_param('bio');

      if(!empty($image))
      {
        $user->image        = $image;
      }      
          
      $id = R::store($user);
      redirect('index.php?p=login&m=registered');           
  }
}

?>

<div class="container">

  <form class="form-signin" id="signup" method="post" action="index.php?p=signup" enctype="multipart/form-data">
      <label>Name</label>
      <input type="text" name="fullname" class="span3 validate[required]" placeholder="What is your name?" value="">

      <label>Email</label>
      <div class="input-prepend">
              <span class="add-on">@</span>
        <input type="text" name="email" class="span3 validate[required,custom[email]]" placeholder="Your Email Address" value="">
      </div>

      <label>Password</label>
      <input id="password" type="password" name="password" class="span3 validate[required]" placeholder="Your Password?" value="">

      <label>Retype Password</label>
      <input type="password" name="retype-password" class="span3 validate[required,equals[password]]" placeholder="Retype your Password?" value="">

      <label>miniTwitter Username</label>
      <span class="add-on">@</span>
      <input class="span2 validate[required]" id="prependedInput" size="16" type="text" name="twitter_name" placeholder="Your Username" value="">

      <label>Bio</label>
      <textarea rows="4" name="bio" class="validate[required]" placeholder="Tell us about yourself !!"></textarea>

      <label>Profile Image</label>
      <div class="row">
        <div class="span2">
          <div class="thumbnail">
          <a href="" class="profile-zoom">
              <img src="http://placehold.it/160x120" alt="">
          </a>
          </div>
          <input class="input-file" id="fileInput" name="image" type="file">
        </div>
      </div>
      <button type="submit" name="submit" value="Register" class="btn" >Register</button>
  </form>  
</div> <!-- /container -->

<script>
$(document).ready(function() {
  $("#signup").validationEngine();
  mT.generate('Yahoo !! You are just one step away from miniTwitter');
});
</script>