<?php
  include('config.php');
  include('header.php');

  isLogin();

  /*$user_details = R::findOne('user',' twitter_name = ?', array(optional_param('u')));
  $tweets = R::find('tweets',' userid = ? ORDER BY id DESC', array($user_details['id']));

  $following = R::findOne('following','userid = ? AND follows = ?', array($_SESSION['user_id'],$user_details->id));

  if(empty($following))
  	$current_user_follow_check = false;
  else
  	$current_user_follow_check = true;

  $profile_image = profilePicPath($user_details->id);
  */

?>
<div class="container-narrow">
	<div class="jumbotron offset2 well swell-small span6">

		<ul class="nav nav-tabs">
		  <li class="active"><a href="#follow" data-toggle="tab">Users you follow</a></li>
		  <li><a href="#following" data-toggle="tab">Users who follow you</a></li>
		  <li><a href="#others" data-toggle="tab">Other users</a></li>
		  <li><a href="#intresting" data-toggle="tab">Interesting users</a></li>		  
		</ul>

		<div class="tab-content userlist">
			<div class="tab-pane active" id="follow">
				<?php

					$following_data = R::getAll('
						SELECT following.userid,
						       following.follows,
						       user.fullname,
						       user.twitter_name,
						       user.bio,
						       user.id
						  FROM    following following
						       INNER JOIN
						          user user
						       ON (following.follows = user.id)
						 WHERE (following.userid = '.$_SESSION['user_id'].')						 
					');

					foreach ($following_data as $key => $fd) {

						$name = $fd['fullname'];
						$twitter_name = $fd['twitter_name'];
						$bio = $fd['bio'];
						$uid = $fd['id'];
						$profile_image = profilePicPath($fd['id']);

						echo <<<OP
						<div class="media user-box-$uid">
							<a class="pull-left" href="user.php?u=$twitter_name">
        						<img class="media-object" data-src="" alt="64x64" style="width: 64px;" src="$profile_image">
      						</a>
      						<div class="media-body">
      							<h4 class="media-heading clearfix">
      								<a class="pull-left" href="user.php?u=$twitter_name">
        								$name
        							</a>
        							<p><button data-method="unfollow" data-userid="$uid" type="button" class="follow-unfollow btn-mini btn-primary pull-right">Unfollow</button></p>
    							</h4>
        						<p>$bio</p>
        			        </div>
    					</div>
OP;
					}
				?>
			</div>
			<div class="tab-pane" id="following">
				<?php

					$followers_data = R::getAll('
						SELECT following.follows,
						       following.userid,
						       user.fullname,
						       user.twitter_name,
						       user.bio,
						       user.id
						  FROM    following following
						       INNER JOIN
						          user user
						       ON (following.userid = user.id)
						 WHERE (following.follows = '.$_SESSION['user_id'].')
					');

					foreach ($followers_data as $key => $fd) {

						$name = $fd['fullname'];
						$twitter_name = $fd['twitter_name'];
						$bio = $fd['bio'];
						$uid = $fd['id'];
						$profile_image = profilePicPath($fd['id']);

						$following = R::findOne('following','userid = ? AND follows = ?', array($_SESSION['user_id'],$uid));

						if(empty($following))
						  	$current_user_follow_check = false;
						else
						  	$current_user_follow_check = true;

						if($current_user_follow_check)
							$follow_button = '<p><button data-method="unfollow" data-userid="$uid" type="button" class="follow-unfollow btn-mini btn-primary pull-right">Unfollow</button></p>';
						else
							$follow_button = '<p><button data-method="follow" data-userid="$uid" type="button" class="follow-unfollow btn-mini btn-warning pull-right">Follow</button></p>';
						

						echo <<<OP
						<div class="media">
							<a class="pull-left" href="user.php?u=$twitter_name">
        						<img class="media-object" data-src="" alt="64x64" style="width: 64px;" src="$profile_image">
      						</a>
      						<div class="media-body">
      							<h4 class="media-heading clearfix">
      								<a class="pull-left" href="user.php?u=$twitter_name">
        								$name
        							</a>
        							$follow_button
    							</h4>
        						<p>$bio</p>
        			        </div>
    					</div>
OP;
					}
				?>
			</div>
			<div class="tab-pane" id="others">
				<?php

					$other_user_data = R::getAll('
						SELECT 	user.id,
								user.fullname,
								user.twitter_name,
								user.bio
						FROM user user
						WHERE user.id NOT IN (
												SELECT DISTINCT user.id
											  	FROM    following following
											       INNER JOIN
											          user user
											       ON (following.follows = user.id)
											 	WHERE (following.userid = '.$_SESSION['user_id'].')
												
												UNION
												
												SELECT DISTINCT user.id
												FROM    following following
												       INNER JOIN
												          user user
												       ON (following.userid = user.id)
												 WHERE (following.follows = '.$_SESSION['user_id'].')
											)
					');

					foreach ($other_user_data as $key => $oud) {

						$name = $oud['fullname'];
						$twitter_name = $oud['twitter_name'];
						$bio = $oud['bio'];
						$uid = $oud['id'];
						$profile_image = profilePicPath($oud['id']);

						$following = R::findOne('following','userid = ? AND follows = ?', array($_SESSION['user_id'],$uid));

						if(empty($following))
						  	$current_user_follow_check = false;
						else
						  	$current_user_follow_check = true;

						if($current_user_follow_check)
							$follow_button = '<p><button data-method="unfollow" data-userid="$uid" type="button" class="follow-unfollow btn-mini btn-primary pull-right">Unfollow</button></p>';
						else
							$follow_button = '<p><button data-method="follow" data-userid="$uid" type="button" class="follow-unfollow btn-mini btn-warning pull-right">Follow</button></p>';
						

						echo <<<OP
						<div class="media">
							<a class="pull-left" href="user.php?u=$twitter_name">
        						<img class="media-object" data-src="" alt="64x64" style="width: 64px;" src="$profile_image">
      						</a>
      						<div class="media-body">
      							<h4 class="media-heading clearfix">
      								<a class="pull-left" href="user.php?u=$twitter_name">
        								$name
        							</a>
        							$follow_button
    							</h4>
        						<p>$bio</p>
        			        </div>
    					</div>
OP;
					}
				?>
			</div>
			<div class="tab-pane" id="intresting">
				<h4> List all paid users here. More $$
			</div>
		</div>
		
    </div>
</div>

<script>
$(document).ready(function() {
	$('.follow-unfollow').bind('click', function() {		
		mT.doAjax('ajax.php',{ m: $(this).data('method'), userid: $(this).data('userid') }, $(this), mT.doFollowUnfollowBulk);
	});
});
</script>

<?php
  include('footer.php');
?>