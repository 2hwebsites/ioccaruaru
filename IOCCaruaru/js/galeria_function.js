var posIni = 1;
var numImages = 1;
var maginPadding = 10;
var ident = 0;

$(function(){
	var width = (parseInt($('.imgDemo').outerWidth() + parseInt($('.imgDemo').css('margin-left'))) * $('.imgDemo').length);
	$('.inline-carrossel').css('width', width);	
});

function setPosisaoInicial(n){
	posIni = n;
	
}

function posicaoInicial(n){
	var quantDemo = $('.imgDemo').length;
	
	if(n > (quantDemo - 2)){
		n = quantDemo - 2;
	}

	if(posIni != n){
		if(posIni < n){
			proxDemo(1, (n - posIni));
		} else{	
			antDemo(1, (posIni - n));
		}
		
		posIni = n;
	}
}

function proxDemo(posInicial, repeticoes){
	var quantDemo = $('.imgDemo').length;
	var count = (quantDemo - 2);
	
	if(posInicial == 1){
		repeticoes = repeticoes - ident;
	}
	
	var slide = ((numImages * maginPadding) + ($('.imgDemo').outerWidth() * numImages)) * repeticoes;
	
	if(posInicial == 1){
		$('.inline-carrossel').animate({'margin-left': '-=' + slide + 'px'}, '10');
		
		ident = 0;
	} else{
		if(((posIni == count) && (ident < 0)) || ((posIni + ident) < count)){
			ident++;
			$('.inline-carrossel').animate({'margin-left': '-=' + slide + 'px'}, '500');
		}
	}
}

function antDemo(posInicial, repeticoes){
	var count = posIni - 1;
	
	if(posInicial == 1){
		repeticoes = repeticoes + ident;
	}
	
	var slide = ((numImages * maginPadding) + ($('.imgDemo').outerWidth() * numImages)) * repeticoes;
	
	if(posInicial == 1){
		$('.inline-carrossel').animate({'margin-left': '+=' + slide + 'px'}, '10');
		
		ident = 0;
	} else{
		if(((posIni == 1) && (ident > 0)) || (posIni > 1) && ((posIni + ident) > 1)){
			ident--;
			$('.inline-carrossel').animate({'margin-left': '+=' + slide + 'px'}, '500');
		}
	}
}

function ajustarImagem(n){
	var imgModal = " .imgModal" + n;
	
	var width = parseInt($('.mySlides' + imgModal).outerWidth());
	var marginLeft = (809 - width) / 2;
	$('.mySlides' + imgModal).css('margin-left', marginLeft);
	$('.mySlides .numbertext').css('margin-left', marginLeft);
	$('.modal-content .caption-container').css('left', marginLeft);
	$('.modal-content .prev').css('left', marginLeft);
	$('.modal-content .next').css('right', marginLeft);
	
	
	
	var height = parseInt($('.mySlides' + imgModal).outerHeight());
	var marginTop = (455 - height) / 2;
	$('.mySlides' + imgModal).css('margin-top', marginTop);
	$('.mySlides .numbertext').css('margin-top', marginTop);
	$('.modal-content .caption-container').css('bottom', marginTop);
	
}
