<!-- Critica o formulário de conteúdo. -->
function critica_conteudo(formName){
	// Data
	if (formName.data.value == ""){
		formName.
		document.getElementById("msgData").innerHTML = "<font color='red'>*Informe a data</font>";
		formName.data.focus();
		return (false);
	} else{
		document.getElementById("msgData").innerHTML = "<font></font>";
	}

	// Título
	if (formName.titulo.value == ""){
		document.getElementById("msgTitulo").innerHTML = "<font color='red'>*Necessário informar o título</font>";
		formName.titulo.focus();
		return (false);
	} else{
		document.getElementById("msgTitulo").innerHTML = "<font></font>";
	}
	
	// Imagem de Capa
	if (formName.thumb.value == ""){
		document.getElementById("msgImgCapa").innerHTML = "<font color='red'>*Necessário informar a imagem de capa</font>";
		formName.thumb.focus();
		return (false);
	} else{
		document.getElementById("msgImgCapa").innerHTML = "<font></font>";
		
		//erro = verificaImagem(formName.thumb.value);
//		
//		if(erro){
//			formName.thumb.focus();
//			return (false);
//		}
	}
	
	// Imagem da Galeria
	if (formName.galeria.value == ""){
		document.getElementById("msgImgGaleria").innerHTML = "<font color='red'>*Necessário informar a imagem da galera</font>";
		formName.galeria.focus();
		return (false);
	} else{
		document.getElementById("msgImgGaleria").innerHTML = "<font></font>";
		
		erro = verificaImagem();
		
		if(erro){
			formName.galeria.focus();
			return (false);
		}
	}
	
	return (true);
}

function verificaImagem(){
	var imagens = document.getElementById("galeriaFiles");
	alert(imagens.files.length);
	//imagens = new array();
//	imagens[i].files[i]
//	extensoes_permitidas = new Array(".gif", ".jpg", ".png");
//  
//  	// Verifica se a extensão está entre as permitidas
//	for (var i = 0; i < imagens.length; i++){ 
//		// Recupera a extensão do arquivo 
//	  	extensao = (imagens[i].substring(imagens[i].lastIndexOf("."))).toLowerCase();
//		
//		if(extensoes_permitidas.indexOf(extensao) < 0){
//			document.getElementById("msgImgCapa").innerHTML = "<font color='red'>*Só é permitido imagens com as extensões: " + extensoes_permitidas.join() + "</font>";
//			return 1;
//		}
//	}
//	
//	return 0;  
}