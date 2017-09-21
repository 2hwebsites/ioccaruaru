$('.carousel-galery').jCarouselLite({
	btnNext: "#galeria-individual .next",
	btnPrev: "#galeria-individual .prev",
	speed: 800,
	easing: "backout"
});

$(".carousel-galery img").click(function() {
	$("#imgFull img").attr("src", $(this).attr("src"));
});