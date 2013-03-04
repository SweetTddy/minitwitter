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
						doneFunction.call(element);
				}).fail(function() {
					if(failFunction != null)
						failFunction.call();
				}).always(function() {
					if(alwaysFunction != null)
						alwaysFunction.call();
				});
	},
	tweetSuccess:function(){
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
	}
}
$(document).ready(function() {
	mT.init();
});