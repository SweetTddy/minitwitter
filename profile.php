<?php

$message = optional_param('m');

if(!empty($_POST))
{

  $master_image_path = "users";

  $size[] = array('width' => 160 , 'height' => 120);
  $size[] = array('width' => 500 , 'height' => 500);

  $target_path = $CFG->dataroot."/$master_image_path/";
  if(!file_exists($target_path)){
    mkdir($CFG->dataroot."/$master_image_path",0755,true);
  }

  if(optional_param('submit') == 'Update')
  {

      if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
      {
        $image = upload_image('image',$target_path,$size);      
        if($image)
          $image = $image;
        else
        $image = '';
      }

      $user = R::load('user',optional_param('id'));    
      
      $user->id     = optional_param('id');
      $user->fullname     = optional_param('fullname');
      $user->email        = optional_param('email');      
      $user->twitter_name = optional_param('twitter_name');
      $user->bio          = optional_param('bio');

      if(!empty($image))
      {
        $user->image        = $image;
      }
    
      $id = R::store($user);
      redirect('index.php?p=profile&m=profile-update');           
  }
}
else
{
    $user_details = R::findOne('user',' id = ? AND email = ?', array($_SESSION['user_id'], $_SESSION['email']));
}

?>

<div class="container">

  <form class="form-signin" id="profile" method="post" action="index.php?p=profile" enctype="multipart/form-data">
      
      <input type="hidden" name="id" class="span3 validate[required]" value="<?php echo $user_details['id'] ?>">

      <label>Name</label>
      <input type="text" name="fullname" class="span3 validate[required]" placeholder="What is your name?" value="<?php echo $user_details['fullname'] ?>">

      <label>Email</label>
      <div class="input-prepend">
              <span class="add-on">@</span>
        <input type="text" name="email" class="span3 validate[required,custom[email]]" placeholder="Your Email Address" value="<?php echo $user_details['email'] ?>">
      </div>

      <label>miniTwitter Username</label>
      <span class="add-on">@</span>
      <input class="span2 validate[required]" id="prependedInput" size="16" type="text" name="twitter_name" placeholder="Your Username" value="<?php echo $user_details['twitter_name'] ?>">

      <label>Bio</label>
      <textarea rows="4" name="bio" class="validate[required]" placeholder="Tell us about yourself !!"><?php echo $user_details['bio'] ?></textarea>

      <label>Profile Image</label>
      <div class="row">
        <div class="span2">
          <div class="thumbnail">            
          <a href="#profile-image" data-toggle="modal">

            <?php
              if(!empty($user_details['image']))
              {
            ?>
                <img src="<?php echo $CFG->siteroot; ?>/uploads/users/f1_<?php echo $user_details['image']; ?>" alt="<?php echo $user_details['image']; ?>">
            <?php
              }
              else
              {
            ?>
                <img src="http://placehold.it/160x120" alt="">
            <?php
              }
            ?>
          </a>
          </div>
          <input class="input-file" id="fileInput" name="image" type="file">
        </div>
      </div>
      <button type="submit" name="submit" value="Update" class="btn" >Update</button>
  </form>  
</div> <!-- /container -->

<?php
if(!empty($user_details['image']))
{
?>
<!-- Modal -->
    <div id="profile-image" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-body">
        <img src="<?php echo $CFG->siteroot; ?>/uploads/users/<?php echo $user_details['image']; ?>" alt="<?php echo $user_details['image']; ?>">
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>        
      </div>
    </div>
<?php
}
?>

<?php

if(!empty($message))
{
  if($message == 'profile-update')
  {
    echo <<<OP
      <script>$(document).ready(function() {mT.generate('Hola !! Your profile is updated');});</script>
OP;
  }
  
}
else
{
  echo <<<OP
      <script>$(document).ready(function() {mT.generate('So you wanna update some thing !!');});</script>
OP;
}

?>