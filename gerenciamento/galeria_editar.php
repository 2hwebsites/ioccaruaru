<?php	
	//inicializa as variáveis
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cont = 0;
		$campos = array();
		$valores = array();
		$prefixo = date("ymdHis");
		
		$campos[$cont] = "titulo";
		$valores[$cont] = "'".$_POST['titulo']."'";
		$cont++;
		
		$urlPost = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($_POST["titulo"])));
		$urlPost = preg_replace('/[ -]+/', '-', $urlPost);
		$campos[$cont] = "url_post";
		$valores[$cont] = "'".$urlPost."'";
		$cont++;
		
		$campos[$cont] = "usuario_id";
		$valores[$cont] = "'".$usuario['id']."'";
		
		if(AlterarDados($campos, $valores, "ioc_posts", $id)){
			// Obtém as imagens da galeria
			$file = $_FILES['imgGaleria'];
			$numFile = count(array_filter($file['name']));

			for($i = 0; $i <= $numFile; $i++){
				$imgGaleria[$i] = $prefixo.preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos(substr($file['name'][$i], 0, -4))));
				$imgGaleria[$i] = preg_replace('/[ -]+/', '_', $imgGaleria[$i]).".jpg";
				$galeriaTmp[$i] = $file['tmp_name'][$i];
			}

			inserirGaleria($id, $imgGaleria, $numFile);

			$path = "../data2/images/";
			$pathThumbnail = "../data2/tooltips/";
			$pathTmp = "../upload/tmp/";
			
			for($i = 0; $i < $numFile; $i++){
				if(!move_uploaded_file($galeriaTmp[$i], $pathTmp.$imgGaleria[$i])){
					$msgErro = "Erro ao fazer o upload da imagem";
				}
				
				AjustaImagem($pathTmp, $path, $pathThumbnail, $imgGaleria[$i], 1600, 900, true, 48, false, true);
			}
		}

		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=galerias&cat=1&us=".$usuario['id']."'>";
	}
	
	include "../connections/conn.php";

	$res_galeria = mysqli_fetch_assoc(mysqli_query($conn, "SELECT titulo From ioc_posts WHERE id = '".$id."'"));
	mysqli_close($conn);
	
	$titulo = $res_galeria['titulo'];
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="galeria_editar" id="galeria_editar">
    	<fieldset>
        	<legend>Editar Galeria</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" 
                	alt="obrigatorio" value="<?php echo $titulo; ?>" />
            </label>
            
            <label class="full">
            	<strong class="legendaCampos">Imagens da Galeria<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgGaleria" name="imgGaleria[]" class="full input" alt="obrigatorio" multiple="multiple" />
            </label>

			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>