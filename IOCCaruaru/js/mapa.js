//Pontos no mapa
var locations = [
	[1, -8.27576, -35.973657, 'IOC - Instituto de Olhos de Caruaru', '<div id="iw-container"><img src="img/logo-circulo-IOC.jpg" alt="" /><div class="iw-title">IOC - Instituto de Olhos de Caruaru</div><br />' + '<p class="primeiro-paragrafo">Sede localizada na Rua Walfrido Nunes, 303</p>' + '<p>Maurício de Nassau - Caruaru-PE - CEP 55.012-120</p>' + '<p>Fone/Pabx: (81) 3723-4444 | 2103-3333</p>' + '<p>Fax: (81) 2103-3334</p></div>'],
	[2, -8.2777854,-35.9711937, 'IOC - Empresarial Difusora', '<div id="iw-container"><img src="img/logo-circulo-IOC.jpg" alt="" /><div class="iw-title">IOC - Instituto de Olhos de Caruaru</div><br />' + '<p class="primeiro-paragrafo">Consultório localizado no Empresarial Difusora</p>' + '<p>Sala 222 - 7º andar</p>' + '<p>Maurício de Nassau - Caruaru-PE - CEP 55.012-290</p>' + '<p>Fone: (81) 2103-9751</p></div>']
];
function initialize() {
	// Exibir mapa;
	var myLatlng = new google.maps.LatLng(-8.276651, -35.972875);
	var mapOptions = {
		zoom: 16,
		center: myLatlng,
		panControl: false,
		mapTypeIds: google.maps.MapTypeId.ROADMAP
	};

	// Exibir o mapa na div #mapa_google;
  	var map = new google.maps.Map(document.getElementById("mapa-google"), mapOptions);
	
 	// Marcador personalizado;
	var image = 'img/marcador-mapa.png';
	
	//Janela de informação
	var infowindow = new google.maps.InfoWindow();
	
	var marker;
	
	for (i = 0; i < locations.length; i++) {  
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map,
			icon: image,
			title: locations[i][3],
			animation: google.maps.Animation.DROP
	  	});
		
		google.maps.event.addListener(marker, 'click', (function(marker, valor) {
			return function() {
				infowindow.setContent(valor);
				infowindow.open(map, marker);
			} 
		})(marker, locations[i][4]));
	}
}

// Função para carregamento assíncrono
function loadScript() {
	var script = document.createElement("script");
  	script.type = "text/javascript";
  	script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyA8QLsnTXopvk4DHykMWvOijpViCPCd3lw&callback=initialize";
 
  	document.body.appendChild(script);
}
 
window.onload = loadScript;