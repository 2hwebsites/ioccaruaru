<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	$ajustarImagem = 0;

	include "../connections/conn.php";
	
	$carrosselSQL = "SELECT titulo, thumb, url_post FROM ioc_posts WHERE id = '".$id."'";
	$carrosselQY = mysqli_fetch_assoc(mysqli_query($conn, $carrosselSQL));
	
	mysqli_close($conn);
	
	$titulo = $carrosselQY['titulo'];
	$thumb = $carrosselQY['thumb'];
	$urlPost = $carrosselQY['url_post'];
	
	$thumbDemo = "../data1/images/".$thumb;
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){		
		$titulo = $_POST['titulo'];
		$urlPost = $_POST['url'];
		$data = date("Y-m-d H:i:s");
		
		if(isset($_FILES['imgcapa']) && !empty($_FILES['imgcapa']['name'])){
			$ajustarImagem = 1;
			$prefixo = date("ymdHis");
			$thumb = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos(substr($_FILES['imgcapa']['name'], 0, -4))));
			$thumb = $prefixo.preg_replace('/[ -]+/', '_', $thumb).".jpg";
			$thumbTmp = $_FILES['imgcapa']['tmp_name'];
		}
		
		$campos = array(
					0 => "titulo",
					1 => "data",
					2 => "thumb", 
					3 => "url_post",
					4 => "usuario_id");
					
		$valores = array(
					0 => "'".$titulo."'",
					1 => "'".$data."'",
					2 => "'".$thumb."'",
					3 => "'".$urlPost."'",
					4 => "'".$usuario['id']."'");
		
		if(AlterarDados($campos, $valores, "ioc_posts", $id)){
			if($ajustarImagem){
				$path = "../data1/images/";
				$pathThumbnail = "../data1/tooltips/";
				$pathTmp = "../upload/tmp/";
				
				if(file_exists($path.$carrosselQY['thumb'])){
					unlink($path.$carrosselQY['thumb']);
				}
				
				if(file_exists($pathThumbnail.$carrosselQY['thumb'])){
					unlink($pathThumbnail.$carrosselQY['thumb']);
				}
				
				if(!move_uploaded_file($thumbTmp, $pathTmp.$thumb)){
					$msgErro = "Erro ao fazer o upload da imagem";
				}
				
				AjustaImagem($pathTmp, $path, $pathThumbnail, $thumb, 1024, 300, true, 48, false, true);
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=carrosseis&cat=4&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="carrossel_editar" id="carrossel_editar">
    	<fieldset>
        	<legend>Editar Carrossel</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus 
                	value="<?php echo $titulo; ?>" />
            </label>

            <label class="full">
            	<strong class="legendaCampos">Imagem de Capa<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgcapa" name="imgcapa" class="full input" />    
            </label>
            
            <label id="lblImgCarrosselDemo" class="lblImgCarrosselDemo">
                <img src="<?php echo $thumbDemo; ?>" alt="" class="imgDemo" />
                <strong class="legendaCampos"><?php echo substr($thumb, 12); ?></strong>
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL</strong>
                <textarea name="url" id="url" class="textarea full textarea txaTextarea"><?php echo $urlPost; ?></textarea>
            </label>
            
            <input type="hidden" id="thumbCapa" name="thumbCapa" value="<?php echo $thumb; ?>" />
			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>