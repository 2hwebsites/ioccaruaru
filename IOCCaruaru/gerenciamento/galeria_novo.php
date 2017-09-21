<?php	
	//inicializa as variáveis
	$id = '';
	$titulo = '';
	$data = '';
	$thumb = '';
	$thumbTmp = '';
	$url_post = '';
	$autor= '';
	$campos = '';
	$valores = '';
	$imgGaleria = '';
	$file = '';
	$erro = 1;
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$titulo = $_POST['titulo'];
		$data = date("Y-m-d H:i:s");
		$prefixo = date("ymdHis");
		$thumb = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos(substr($_FILES['imgcapa']['name'], 0, -4))));
		$thumb = preg_replace('/[ -]+/', '_', $thumb).".jpg";
		$thumbTmp = $_FILES['imgcapa']['tmp_name'];
		$urlPost = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($_POST['titulo'])));
		$urlPost = preg_replace('/[ -]+/', '-', $urlPost);
		$autor = $usuario['nome_resumido'];
		
		$campos = array(
					0 => "titulo", 
					1 => "data", 
					2 => "thumb",
					3 => "url_post", 
					4 => "autor", 
					5 => "categoria_id", 
					6 => "usuario_id");
					
		$valores = array(
					0 => "'".$titulo."'",
					1 => "'".$data."'", 
					2 => "'".$prefixo.$thumb."'",
					3 => "'".$urlPost."'", 
					4 => "'".$autor."'",
					5 => '1',
					6 => "'".$usuario['id']."'");

		if($id = InserirDados($campos, $valores, "ioc_posts")){	
			// Obtém as imagens da galeria
			$file = $_FILES['imgGaleria'];
			$numFile = (count(array_filter($file['name'])) + 1);
			$imgGaleria[0] = $prefixo.$thumb;
			$galeriaTmp[0] = $thumbTmp;

			for($i = 1; $i < $numFile; $i++){
				$imgGaleria[$i] = $prefixo.preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos(substr($file['name'][$i-1], 0, -4))));
				$imgGaleria[$i] = preg_replace('/[ -]+/', '_', $imgGaleria[$i]).".jpg";
				$galeriaTmp[$i] = $file['tmp_name'][$i-1];
			}

			inserirGaleria($id, $imgGaleria, $numFile);

			$path = "../data2/images/";
			$pathThumbnail = "../data2/tooltips/";
			$pathTmp = "../upload/tmp/";
			$pathImgCapa = "../upload/galeria/".sprintf("%06d", $id)."/";
			mkdir($pathImgCapa);

			for($i = 0; $i < $numFile; $i++){
				if(!move_uploaded_file($galeriaTmp[$i], $pathTmp.$imgGaleria[$i])){
					$msgErro = "Erro ao fazer o upload da imagem";
				}
				
				if($i == 0){
					AjustaImagem($pathTmp, "", $pathImgCapa, $imgGaleria[$i], 1326, 900, false, 95, true, false);
				}
				AjustaImagem($pathTmp, $path, $pathThumbnail, $imgGaleria[$i], 1600, 900, true, 48, false, true);
			}
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=galerias&cat=1&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="galeria_novo" id="galeria_novo">
    	<fieldset>
        	<legend>Cadastrar Galeria</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" 
                	alt="obrigatorio" />
            </label>

            <label class="full">
            	<strong class="legendaCampos">Imagem de Capa<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgcapa" name="imgcapa" class="full input" alt="obrigatorio" />    
            </label>
             
             <label class="full">
            	<strong class="legendaCampos">Imagens da Galeria<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgGaleria" name="imgGaleria[]" class="full input" alt="obrigatorio" multiple="multiple" />
            </label>

			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>