<?php
  include('config.php');
  include('header.php');

  isLogin();

  $user_details = R::findOne('user',' twitter_name = ?', array(optional_param('u')));
  $tweets = R::find('tweets',' userid = ? ORDER BY id DESC', array($user_details['id']));

  $following = R::findOne('following','userid = ? AND follows = ?', array($_SESSION['user_id'],$user_details->id));

  if(empty($following))
  	$current_user_follow_check = false;
  else
  	$current_user_follow_check = true;

  $profile_image = profilePicPath($user_details->id);

?>
<div class="container-narrow">
	<div class="jumbotron">
		<div class="row">
  			<div class="span4">
  				<div class="well">
					<div class="flex-module profile-summary js-profile-summary">
						<a href="user.php?u=<?php echo $user_details['twitter_name'];?>" class="account-summary account-summary-small js-nav" data-nav="profile">
							<div class="content">
								<div class="row">
									<div class="span1">
										<div class="account-group js-mini-current-user" data-user-id="47271576" data-screen-name="robinflyhigh">
											<?php profilePic($user_details->id) ?>
										</div>
									</div>								
									<div class="span3">
										<b class="fullname"><?php echo $user_details->fullname; ?></b>
										<br/>
										<span><?php echo $user_details->bio; ?></span>
									</div>
								</div>
							</div>
						</a>
					</div>

					<div class="js-mini-profile-stats-container">
						<ul class="stats js-mini-profile-stats" data-user-id="47271576">
							<li>
								<a class="js-nav" href="#" data-element-term="tweet_stats" data-nav="profile">
									<strong><?php echo userTotalTweets($user_details->id) ?></strong> Tweets
								</a>
							</li>
							<li>
								<a class="js-nav" href="#" data-element-term="following_stats" data-nav="following">
									<strong><?php echo userTotalFollowing($user_details->id) ?></strong> Following
								</a>
							</li>
							<li>
								<a class="js-nav" href="#" data-element-term="follower_stats" data-nav="followers">
									<strong><?php echo userTotalFollowers($user_details->id) ?></strong> Followers
								</a>
							</li>
						</ul>
					</div>
					<br>

					<?php
						if($user_details->id != $_SESSION['user_id'])
						{
							if($current_user_follow_check)
								echo '<p><button id="follow-unfollow" data-method="unfollow" data-userid="'.$user_details->id.'" type="button" class="btn-small btn-primary">Unfollow</button></p>';
							else
								echo '<p><button id="follow-unfollow" data-method="follow" data-userid="'.$user_details->id.'" type="button" class="btn-small btn-warning">Follow</button></p>';
						}

					?>
					

  				</div>
  				<div class="well">
					<h3> Ad Block for $$ </h3>
  				</div>

  			</div>
  			<div class="span6 well tweetContainer">

  				<?php
  				foreach($tweets as $tweet)
  				{
  					$tweet = $tweet->tweets;
  					echo <<<OP
	 			
						<div class="media">
							<a class="pull-left" href="#">
								<img class="media-object" data-src="" alt="64x64" style="width: 64px;" src="$profile_image">
							</a>
							<div class="media-body">
								$tweet
							</div>
						</div>
						<hr>
OP;
				}
				?>
  			</div>
		</div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#follow-unfollow').bind('click', function() {		
		mT.doAjax('ajax.php',{ m: $("#follow-unfollow").data('method'), userid: $("#follow-unfollow").data('userid') }, mT.followSuccess);
	});
});
</script>

<?php
  include('footer.php');
?>