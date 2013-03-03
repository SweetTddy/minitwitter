var mT = {

	varname1:'val1',
	varname2:'val2',
	
	init:function(){
		$(".profile-zoom").colorbox({height:"75%"});		
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

	doAjax:function(url,values,doneFunction,failFunction,alwaysFunction){

		$.ajax(
				{
					type: "GET",
					url: url,
					data: values,
				}).done(function() {
					doneFunction.call();
				}).fail(function() {
					doneFunction.call();
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

}
$(document).ready(function() {
	mT.init();	
});