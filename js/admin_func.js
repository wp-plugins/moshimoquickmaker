var jq = jQuery.noConflict();

///ErrorMessage
function Un_msm_ErrorResult(geterror_array){
	for (var i in geterror_array) {
		jq("#"+i).html(geterror_array[i]);
	}
}

function Un_msm_JustifyHeight(css_name){
	if(css_name){
		css_name = "."+css_name;
	}
	jq('ul'+css_name).each(function(){
		var rep = 0;
		jq(this).children().each(function(){
			var itemHeight = parseInt(jq(this).css('height'));
			if(itemHeight > rep){
				rep = itemHeight;
			};
		});
		jq(this).children().css({height:(rep)});
	});
}
