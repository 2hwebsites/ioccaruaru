<?php
	$alterarImagem = 0;
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	include "../connections/conn.php";
	
	$bannerSQL = "SELECT titulo, thumb, url_post FROM ioc_posts WHERE id = '".$id."'";
	$bannerQY = mysqli_fetch_assoc(mysqli_query($conn, $bannerSQL));
	
	mysqli_close($conn);
	
	$titulo = $bannerQY['titulo'];
	$thumb = $bannerQY['thumb'];
	$urlPost = $bannerQY['url_post'];
	
	$thumbDemo = "../upload/banner/".sprintf("%06d", $id)."/".$thumb;
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cont = 0;
		$campos = array();
		$valores = array();
		
		$campos[$cont] = "titulo";
		$valores[$cont] = "'".$_POST['titulo']."'";
		$cont++;
		
		if(!empty($_FILES['imgcapa']['name'])){
			$campos[$cont] = "thumb";
			$valores[$cont] = "'".date("dmyHis").$_FILES['imgcapa']['name']."'";
			$cont++;
			
			$thumbAntigo = $_POST['thumbCapa'];
			$thumb = date("dmyHis").$_FILES['imgcapa']['name'];
			$thumbTmp = $_FILES['imgcapa']['tmp_name'];
			$alterarImagem = 1;
		}
		
		$campos[$cont] = "url_post";
		$valores[$cont] = "'".$_POST['url']."'";
		
		if(!empty($campos)){
			if(AlterarDados($campos, $valores, "ioc_posts", $id)){		
				if($alterarImagem){
					$path = "../upload/banner/".sprintf("%06d", $id);
					
					// Remove a imagem anterior
					if(file_exists($path."/".$thumbAntigo)){
						unlink($path."/".$thumbAntigo);
					}
					
					// Envia a imagem para a pasta temporária do servidor
					$pathTmp = "../upload/tmp/".$thumb;
					
					if(!move_uploaded_file($thumbTmp, $pathTmp)){
						$msg[] = "<b>$imgCapa : </b> Ocorreu um erro ao copiar a imagem!";
					}
					
					// instancia objeto m2brimagem QUE REDIMENSIONA SEM CORTAR
					include_once "m2brimagem.class.0.6.2.php";
					
					// Gera a imagem
					$oImg = new m2brimagem($pathTmp);
					$valida = $oImg->valida();
					$path = $path."/".$thumb;
					
					if($valida == 'OK'){
						$oImg->redimensiona(600,300,'');
						$oImg->grava($path);
					} else {
						// mensagem de erro
						die($valida);
					}
					
					// Remove o arquivo base da pasta temporária
					if(file_exists($pathTmp)){
						unlink($pathTmp);
					}
				}
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=banners&cat=5&us=".$usuario['id']."'>";
	}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="banner_editar" id="banner_editar">
    	<fieldset>
        	<legend>Editar Banner</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" 
                	value="<?php echo $titulo; ?>" alt="obrigatorio" />
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