$(document).ready(function() {
	$('.slider').cycle({
		fx: 'fade',
		timeout: 4000,
		speed: 1500,
		pager: $('.slider-page'),
		pagerAnchorBuilder: function(index, DOMelement){
			return '<a></a>';
		},
		activePagerClass: 'activePager',
		pause: true
	});	
});

$(document).ready(function() {
	var largura = $(".slider-page").width();
	var largura2 = $(".slider").width();
	var margem = (largura2 - largura) / 2;
	var width = screen.width;
	
	if(width <= 768){
		margem += 15;
	}
	
	$(".slider-page").css({ "margin-left": +margem+"px" });
});