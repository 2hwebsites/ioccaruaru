<?php	
	//inicializa as variáveis
	$id = '';
	$titulo = '';
	$data = '';
	$thumb = '';
	$thumbTmp = '';
	$urlPost = '';
	$campos = '';
	$valores = '';
	$path = '';
	$pathTmp = '';
	$oImg = '';
	$valida = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$titulo = $_POST['titulo'];
		$data = date("Y-m-d H:i:s");
		$prefixo = date("ymdHis");
		$thumb = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos(substr($_FILES['imgcapa']['name'], 0, -4))));
		$thumb = $prefixo.preg_replace('/[ -]+/', '_', $thumb).".jpg";
		$thumbTmp = $_FILES['imgcapa']['tmp_name'];
		$urlPost = $_POST['url'];
		
		$campos = array(
					0 => "titulo",
					1 => "data",
					2 => "thumb", 
					3 => "url_post",
					4 => "categoria_id",
					5 => "usuario_id",
					6 => "ativo");
					
		$valores = array(
					0 => "'".$titulo."'",
					1 => "'".$data."'",
					2 => "'".$thumb."'",
					3 => "'".$urlPost."'",
					4 => '4',
					5 => "'".$usuario['id']."'",
					6 => '1');

		if(InserirDados($campos, $valores, "ioc_posts") > 0){
			$path = "../data1/images/";
			$pathThumbnail = "../data1/tooltips/";
			$pathTmp = "../upload/tmp/";
			
			if(!move_uploaded_file($thumbTmp, $pathTmp.$thumb)){
					$msgErro = "Erro ao fazer o upload da imagem";
				}
			
			AjustaImagem($pathTmp, $path, $pathThumbnail, $thumb, 1024, 300, true, 48, false, true);
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=carrosseis&cat=4&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="carrossel_novo" id="carrossel_novo">
    	<fieldset>
        	<legend>Cadastrar Carrossel</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus />
            </label>

            <label class="full">
            	<strong class="legendaCampos">Imagem de Capa<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgcapa" name="imgcapa" class="full input" alt="obrigatorio" />    
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL</strong>
                <textarea name="url" id="url" class="textarea full textarea txaTextarea"></textarea>
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>