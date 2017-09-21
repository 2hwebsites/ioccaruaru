<?php require ('thumbClass.php');
	  $prefix = 'nova'; //Novo prefixo para imagem
	  $path = 'temp/'; //Caminho de onde está a imagem temporaria
	  $thumbNail = new thumbNails();
	  $thumbNail->_nName = $prefix; 
	  $thumbNail->_tempPath = $path; 
	  $thumbNail->_url = 'http://www.google.com.br/images/srpr/logo11w.png';
	  $thumbNail->urlImage();
	  $thumbNail->_image = array($path,$thumbNail->_tempImage); //Esta linha deve existir apenas quando você desejar um thumbnail via URL
	  
	  //$thumbNail->_return = 'jpg'; //Esta linha deve existir apenas quando você desejar um thumbnail em outro formato que não seja o mesmo da imagem de origem
      
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>200); //Estica ou Diminui a imagem centralizando a mesma de acordo com quem for maior (x ou y)
	  
	  $thumbNail->_sThumb = array('x'=>200,'y'=>200,'stretched'); //Estica ou Diminui a imagem no tamanho setado em x e y
	  
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>0,'thumb'); //Estica ou Diminui a imagem obtendo x como parametro
	  
	  //$thumbNail->_sThumb = array('x'=>0,'y'=>600,'expanded'); //Estica ou Diminui a imagem obtendo y como parametro
      
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>54,'centered'); //Diminui ou Mantem a imagem centralizando a mesma dentro de x e y
	  
	  //$thumbNail->_sThumb = array('x'=>370,'y'=>0,'param_center'); //Diminui ou Mantem a imagem centralizando de acordo com o que for definido x ou y
	  
	  header($thumbNail->_header);
	  echo $thumbNail->pageImage();
?>
