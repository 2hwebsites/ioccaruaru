<?php require ('thumbClass.php');
	  $prefix = 'nova'; //Novo prefixo para imagem
	  $path = './'; //Caminho de onde está a imagem
	  $image = 'imagem.bmp'; //Nome da imagem
      $thumbNail = new thumbNails();
	  $thumbNail->_nName = $prefix; 
	  $thumbNail->_image = array($path,$image);
	  
	  //$thumbNail->_return = 'jpg'; //Esta linha deve existir apenas quando você desejar um thumbnail em outro formato que não seja o mesmo da imagem de origem
      
	  $thumbNail->_sThumb = array('x'=>200,'y'=>200); //Estica ou Diminui a imagem centralizando a mesma de acordo com quem for maior (x ou y)
	  
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>200,'stretched'); //Estica ou Diminui a imagem no tamanho setado em x e y
	  
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>0,'thumb'); //Estica ou Diminui a imagem obtendo x como parametro
	  
	  //$thumbNail->_sThumb = array('x'=>0,'y'=>600,'expanded'); //Estica ou Diminui a imagem obtendo y como parametro
      
	  //$thumbNail->_sThumb = array('x'=>200,'y'=>54,'centered'); //Diminui ou Mantem a imagem centralizando a mesma dentro de x e y
	  
	  //$thumbNail->_sThumb = array('x'=>370,'y'=>0,'param_center'); //Diminui ou Mantem a imagem centralizando de acordo com o que for definido x ou y
	  
	  //$thumbNail->_sThumb = array('x'=>450,'y'=>450,'w'=>200,'h'=>200,'pos_x'=>120,'pos_y'=>150,'crop'); // x e y tamanho da imagem, w e h tamanho do crop que será feito, pos_x e pos_y posição onde vai começar o crop da imagem
	  
	  //$thumbNail->_sThumb = array('x'=>220,'y'=>220,'crop_auto'); //Estica ou Diminui a imagem proporcionalmente cropando a mesma no centro, de acordo com o que for definido em x e y
	  
	  
	  /*O trecho abaixo pode ser usado para debugar caso esteja dando erro
      ou mesmo criar uma variável com o erro retornado para mostrar a mensagem
      ao usuário*/
      $msg = $thumbNail->_msg;
      echo '<pre>'; print_r($msg);
?>
