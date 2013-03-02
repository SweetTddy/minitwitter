var mT = {

	varname1:'val1',
	varname2:'val2',
	
	init:function(){
		$(".profile-zoom").colorbox({height:"75%"});		
	},

	generate:function(message,time = 5000){
		var n = noty({
						text: message,
						type: 'information',
						timeout: time,
						dismissQueue: true,
						layout: 'bottomRight',
						theme: 'defaultTheme'
		});		
	},	

}
$(document).ready(function() {
	mT.init();	
});