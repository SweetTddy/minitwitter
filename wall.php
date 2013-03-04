<?php

$user_details = R::findOne('user',' twitter_name = ?', array($_SESSION['twitter_name']));

?>
<div class="container-narrow">
	<div class="jumbotron">
		<div class="row">
  			<div class="span4">
  				<div class="well">
					<div class="flex-module profile-summary js-profile-summary">
						<a href="user.php?u=<?php echo $_SESSION['twitter_name'];?>" class="account-summary account-summary-small js-nav" data-nav="profile">
							<div class="content">
								<div class="row">
									<div class="span1">
										<div class="account-group js-mini-current-user" data-user-id="47271576" data-screen-name="robinflyhigh">											
											<?php profilePic($user_details->id) ?>
										</div>
									</div>								
									<div class="span3">
										<b class="fullname"><?php echo $user_details->fullname?></b>
										<br/>										
										<?php echo $user_details->bio?>
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

					<div class="tweet-content">
						<textarea id="tweetText" cols="6" rows="4"></textarea> <br/>
						<p><button id="tweetNow" type="button" class="btn-small btn-success">miniTweet</button></p>
	  				</div>
  				</div>
  				<div class="well">
  					<p>
  						<a href="list.php" class="btn btn-large btn-primary" style="margin-top:10px;">List all Wonders</a>
					</p>
  				</div>
  				<div class="well">
					<div class="tabbable infolist"> <!-- Only required for left/right tabs -->
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1" data-toggle="tab">Most Followed</a></li>
							<li><a href="#tab2" data-toggle="tab">No Followers</a></li>
							<li><a href="#tab3" data-toggle="tab">Most Tweets</a></li>
						</ul>
							<div class="tab-content">
							<div class="tab-pane active" id="tab1">								
								<?php

									$mostFollowed = R::getAll('
										SELECT f.follows,
										       count(*) AS count,
										       u.fullname,
										       u.twitter_name,
										       u.bio,
										       u.id
										FROM    following f
										       INNER JOIN
										          user u
										       ON (f.follows = u.id)
										GROUP BY f.follows
										ORDER BY count DESC LIMIT 0,2
									');

									foreach ($mostFollowed as $key => $mf) {

										$name = $mf['fullname'];
										$twitter_name = $mf['twitter_name'];
										$bio = $mf['bio'];
										$profile_image = profilePicPath($mf['id']);

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
	                							</h4>
		                						<p>$bio</p>
		                			        </div>
		            					</div>
OP;
									}
            					?>		
							</div>
							<div class="tab-pane" id="tab2">
								<?php

									$nonFollwers = R::getAll('
										SELECT u.id,
											u.fullname,
											u.twitter_name,
											u.bio
										FROM user u
											WHERE (u.id NOT IN (SELECT DISTINCT f.follows
												FROM following f)) ORDER BY id DESC LIMIT 0,2
									');

									foreach ($nonFollwers as $key => $nf) {

										$name = $nf['fullname'];
										$twitter_name = $nf['twitter_name'];
										$bio = $nf['bio'];
										$profile_image = profilePicPath($nf['id']);

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
	                							</h4>
		                						<p>$bio</p>
		                			        </div>
		            					</div>
OP;
									}
            					?>
							</div>
							<div class="tab-pane" id="tab3">
								<?php

									$mostTweet = R::getAll('
										SELECT t.userid,
										       count(*) AS count,
										       u.fullname,
										       u.twitter_name,
										       u.bio,
										       u.id
										FROM    tweets t
										       INNER JOIN
										          user u
										       ON (t.userid = u.id)										
										GROUP BY t.userid
										ORDER BY count DESC LIMIT 0,2
									');

									foreach ($mostTweet as $key => $mt) {

										$name = $mt['fullname'];
										$twitter_name = $mt['twitter_name'];
										$bio = $mt['bio'];
										$profile_image = profilePicPath($mt['id']);

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
	                							</h4>
		                						<p>$bio</p>
		                			        </div>
		            					</div>
OP;
									}
            					?>
							</div>
						</div>
					</div>
  				</div>

  			</div>
  			<div class="span6 well tweetContainer">

  				<?php
  					$followers_tweet = R::getAll('
							SELECT tweets.userid,
							       user.id,
							       user.fullname,
							       user.email,
							       user.twitter_name,
							       user.bio,
							       tweets.tweets
							  FROM    tweets tweets
							       INNER JOIN
							          user user
							       ON (tweets.userid = user.id)
							 WHERE (tweets.userid = '.$_SESSION['user_id'].' OR tweets.userid IN (SELECT following.follows
							                            FROM following following
							                           WHERE (following.userid = '.$_SESSION['user_id'].')))
  								ORDER BY id DESC
						');

  					foreach ($followers_tweet as $key => $ft) {

						$name = $ft['fullname'];
						$twitter_name = $ft['twitter_name'];
						$tweet = $ft['tweets'];
						$profile_image = profilePicPath($ft['id']);

						echo <<<OP

						<div class="media">
							<a class="pull-left" href="user.php?u=$twitter_name">
								<img class="media-object" alt="64x64" style="width: 64px;" src="$profile_image">
							</a>
							<div class="media-body">
								<a href="user.php?u=$twitter_name">
									<h4 class="media-heading">$name | @$twitter_name</h4>
								</a>
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
	$('#tweetNow').bind('click', function() {		
		mT.doAjax('ajax.php',{ m: "tweet", text: $("#tweetText").val() }, mT.tweetSuccess);
	});
});
</script>