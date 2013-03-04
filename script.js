var mT = {
	
	init:function(){
		$('#myTab li a').on('shown', function (e) {
  			e.target // activated tab
  			e.relatedTarget // previous tab
		})
	},
	generate:function(message ,time){

		var n = noty({
						text: message,
						type: 'information',
						timeout: 5000,
						dismissQueue: true,
						layout: 'bottomRight',
						theme: 'defaultTheme'
		});		
	},
	doAjax:function(url,values,element,doneFunction,failFunction,alwaysFunction){
		$.ajax(
				{
					type: "GET",
					url: url,
					data: values,
				}).done(function() {
					if(doneFunction != null)
						doneFunction.call(element,values);
				}).fail(function() {
					if(failFunction != null)
						failFunction.call(element,values);
				}).always(function() {
					if(alwaysFunction != null)
						alwaysFunction.call(element,values);
				});
	},
	tweetSuccess:function(values){
		mT.prependTweet(values);
		$("#tweetText").val('');
		mT.generate('Thank You for Tweeting');
	},
	followSuccess:function(){
		if($("#follow-unfollow").data('method') == 'follow')
		{
			$("#follow-unfollow").html('Unfollow');
			$("#follow-unfollow").addClass('btn-primary').removeClass('btn-warning');
			$("#follow-unfollow").data('method','unfollow');
			mT.generate('Bingo !! You are now following the user');
		}
		else
		{
			$("#follow-unfollow").html('Follow');
			$("#follow-unfollow").addClass('btn-warning').removeClass('btn-primary');
			$("#follow-unfollow").data('method','follow');
			mT.generate('He would be upset :(');
		}
	},
	doFollowUnfollow:function(){
		if($(this).data('method') == 'follow')
		{
			$(this).html('Unfollow');
			$(this).addClass('btn-primary').removeClass('btn-warning');
			$(this).data('method','unfollow');
			mT.generate('Bingo !! You are now following the user');
		}
		else
		{
			$(this).html('Follow');
			$(this).addClass('btn-warning').removeClass('btn-primary');
			$(this).data('method','follow');
			mT.generate('He would be upset :(');
		}		
	},
	doFollowUnfollowBulk:function(values){
		if($(this).data('method') == 'follow')
		{
			$(this).html('Unfollow');
			$(this).addClass('btn-primary').removeClass('btn-warning');
			$(this).data('method','unfollow');
			mT.generate('Bingo !! You are now following the user');
		}
		else
		{
			$(this).html('Follow');
			$(this).addClass('btn-warning').removeClass('btn-primary');
			$(this).data('method','follow');
			mT.generate('He would be upset :(');
			//$('.user-box-'+values.userid).fadeOut();
		}		
	},
	prependTweet:function(values){
		$('#total_tweet_container').html('<strong>'+(parseInt($('#total_tweet').val()) + 1)+' Tweets</strong>');
		$('.tweetContainer').prepend('<div class="media"><a href="user.php?u='+$('#username').val()+'" class="pull-left"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACDUlEQVR4Xu2Yz6/BQBDHpxoEcfTjVBVx4yjEv+/EQdwa14pTE04OBO+92WSavqoXOuFp+u1JY3d29rvfmQ9r7Xa7L8rxY0EAOAAlgB6Q4x5IaIKgACgACoACoECOFQAGgUFgEBgEBnMMAfwZAgaBQWAQGAQGgcEcK6DG4Pl8ptlsRpfLxcjYarVoOBz+knSz2dB6vU78Lkn7V8S8d8YqAa7XK83ncyoUCjQej2m5XNIPVmkwGFC73TZrypjD4fCQAK+I+ZfBVQLwZlerFXU6Her1eonreJ5HQRAQn2qj0TDukHm1Ws0Ix2O2260RrlQqpYqZtopVAoi1y+UyHY9Hk0O32w3FkI06jkO+74cC8Dh2y36/p8lkQovFgqrVqhFDEzONCCoB5OSk7qMl0Gw2w/Lo9/vmVMUBnGi0zi3Loul0SpVKJXRDmphvF0BOS049+n46nW5sHRVAXMAuiTZObcxnRVA5IN4DJHnXdU3dc+OLP/V63Vhd5haLRVM+0jg1MZ/dPI9XCZDUsbmuxc6SkGxKHCDzGJ2j0cj0A/7Mwti2fUOWR2Km2bxagHgt83sUgfcEkN4RLx0phfjvgEdi/psAaRf+lHmqEviUTWjygAC4EcKNEG6EcCOk6aJZnwsKgAKgACgACmS9k2vyBwVAAVAAFAAFNF0063NBAVAAFAAFQIGsd3JN/qBA3inwDTUHcp+19ttaAAAAAElFTkSuQmCC" style="width: 64px;" alt="64x64" class="media-object"></a><div class="media-body"><a href="user.php?u='+$('#username').val()+'"><h4 class="media-heading">'+$('#fullname').val()+' | @'+$('#username').val()+'</h4></a>'+values.text+'</div></div>');
	}
}
$(document).ready(function() {
	mT.init();	
});