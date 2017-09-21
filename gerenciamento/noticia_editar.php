<?php	
	//inicializa as variáveis
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	$alterarImagem = 0;
	$alterarBanner = 0;
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cont = 0;
		$campos = array();
		$valores = array();
		
		$campos[$cont] = "titulo";
		$valores[$cont] = "'".$_POST['titulo']."'";
		$cont++;
		
		$urlPost = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($_POST["titulo"])));
		$urlPost = preg_replace('/[ -]+/', '-', $urlPost);
		$campos[$cont] = "url_post";
		$valores[$cont] = "'".$urlPost."'";
		$cont++;
		
		$campos[$cont] = "subtitulo";
		$valores[$cont] = "'".$_POST['subtitulo']."'";
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
		
		$campos[$cont] = "nao_exibir_thumb";
		if(isset($_POST['nao_exibir_thumb'])){
			$valores[$cont] = "'".$_POST['nao_exibir_thumb']."'";
		} else{
			$valores[$cont] = "'0'";
		}
		$cont++;
		
		switch ($_POST['destaque_post']){
			case "selecione":
				$campos[$cont] = "thumb_banner";
				$valores[$cont] = "''";
				$cont++;
				
				$campos[$cont] = "video";
				$valores[$cont] = "''";
				$cont++;
								
				break;
			case "banner":
				if(!empty($_FILES['thumb_banner']['name'])){
					$campos[$cont] = "thumb_banner";
					$valores[$cont] = "'".date("dmyHis").$_FILES['thumb_banner']['name']."'";
					$cont++;
					
					$thumbBannerAntigo = $_POST['thumbBanner'];
					
					$thumbBanner = date("dmyHis").$_FILES['thumb_banner']['name'];
					$thumbBannerTmp = $_FILES['thumb_banner']['tmp_name'];
					$alterarBanner = 1;
				}

				$campos[$cont] = "video";
				$valores[$cont] = "''";
				$cont++;
				
				break;
			case "video":
				$campos[$cont] = "thumb_Banner";
				$valores[$cont] = "''";
				$cont++;
				
				$campos[$cont] = "video";
				$valores[$cont] = "'".$_POST['video']."'";
				$cont++;
				
				break;
		}
		
		$campos[$cont] = "texto";
		$valores[$cont] = "'".trim($_POST['texto'])."'";
		$cont++;

		$campos[$cont] = "usuario_id";
		$valores[$cont] = "'".$usuario['id']."'";
		$cont++;

		if(!empty($campos)){
			if(AlterarDados($campos, $valores, "ioc_posts", $id)){
				if($alterarImagem){
					$path = "../upload/noticias/".sprintf("%06d", $id);
					
					// Remove as imagens anteriores
					if(file_exists($path."/img_g/".$thumbAntigo)){
						unlink($path."/img_g/".$thumbAntigo);
					}
					
					if(file_exists($path."/img_m/".$thumbAntigo)){
						unlink($path."/img_m/".$thumbAntigo);
					}
					
					if(file_exists($path."/img_p/".$thumbAntigo)){
						unlink($path."/img_p/".$thumbAntigo);
					}
			
					// Gera a imagem grande
					geraImg($thumbTmp, 400, 400, $path."/img_g/".$thumb, 90);
			
					// Envia a imagem para a pasta temporária do servidor
					$pathTmp = "../upload/tmp/".$thumb;
			
					if(!move_uploaded_file($thumbTmp, $pathTmp)){
						$msg[] = "<b>$imgCapa : </b> Ocorreu um erro ao copiar a imagem!";
					}
			
					// instancia objeto m2brimagem QUE REDIMENSIONA SEM CORTAR
					include_once "m2brimagem.class.0.6.2.php";
					
					// Gera a imagem média
					$oImg = new m2brimagem($pathTmp);
					$valida = $oImg->valida();
			
					if($valida == 'OK'){
						$oImg->redimensiona(250,150,'');
						$oImg->grava($path."/img_m/".$thumb);
					} else {
						// mensagem de erro
						die($valida);
					}
					
					// Gera a imagem pequena
					$oImg = new m2brimagem($pathTmp);
					$valida = $oImg->valida();
					
					if($valida == 'OK'){
						$oImg->redimensiona(140,95,'');
						$oImg->grava($path."/img_p/".$thumb);
					} else {
						// mensagem de erro
						die($valida);
					}
			
					// Remove o arquivo base da pasta temporária
					if(file_exists($pathTmp)){
						unlink($pathTmp);
					}
				}
			
				// Envia ao servidor a imagem banner
				if($alterarBanner){
					$path = "../upload/noticias/".sprintf("%06d", $id)."/banner/";
					
					// Cria o diretório, se não existir
					if(!file_exists($path)){
						mkdir($path);
					}
					
					// Remove a imagem anterior
					if(isset($thumbBannerAntigo)){
						if($path.$thumbBannerAntigo){
							unlink($path.$thumbBannerAntigo);
						}
					}
	
					geraImg($thumbBannerTmp, 450, 450, $path.$thumbBanner, 90);
				}
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=noticias&cat=2&us=".$usuario['id']."'>";
	}

	include "../connections/conn.php";

	$res_noticia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT titulo, subtitulo, thumb, nao_exibir_thumb, thumb_banner, video, texto, usuario_id
															From ioc_posts WHERE id = '".$id."'"));
	
	mysqli_close($conn);
	
	$titulo = $res_noticia['titulo'];
	$subtitulo = $res_noticia['subtitulo'];
	$thumb = $res_noticia['thumb'];
	$thumbDemo = "../upload/noticias/".sprintf("%06d", $id)."/img_p/".$thumb;
	$thumbBanner = $res_noticia['thumb_banner'];
	$video = $res_noticia['video'];
	$texto = $res_noticia['texto'];
	
	if($res_noticia['nao_exibir_thumb'] == '1'){
		$naoExibirThumb = "Checked";
	} else{
		$naoExibirThumb = "";
	}
	
	$thumbBannerSelecionado = "";
	$videoSelecionado = "";
	$selecione = "";
		
	if(!empty($thumbBanner)){
		$thumbBannerSelecionado = "Selected";
		$thumbBannerDemo = "../upload/noticias/".sprintf("%06d", $id)."/banner/".$thumbBanner;
	} elseif(!empty($video)){
		$videoSelecionado = "Selected";
	} else{
		$selecione = "Selected";
	}
?>
<script>
    tinymce.init({
        selector: "textarea.mceAdvanced",
        theme: "modern",
        language : "pt_BR",
        plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker codesample"
        ],
        external_plugins: {
            //"moxiemanager": "/moxiemanager-php/plugin.js"
        },
        //content_css: "css/development.css",
        add_unload_trigger: false,
        autosave_ask_before_unload: false,
    
        toolbar1: "cut copy paste | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent blockquote | fontselect fontsizeselect",
        toolbar2: "bullist numlist | undo redo | link unlink code | forecolor backcolor | subscript superscript",
        toolbar3: "",
        menubar: false,
        toolbar_items_size: 'small',
    
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
    
        templates: [
            {title: 'My template 1', description: 'Some fancy template 1', content: 'My html'},
            {title: 'My template 2', description: 'Some fancy template 2', url: 'development.html'}
        ],
    
        spellchecker_callback: function(method, data, success) {
            if (method == "spellcheck") {
                var words = data.match(this.getWordCharPattern());
                var suggestions = {};
    
                for (var i = 0; i < words.length; i++) {
                    suggestions[words[i]] = ["First", "second"];
                }
    
                success({words: suggestions, dictionary: true});
            }
    
            if (method == "addToDictionary") {
                success();
            }
        }
    });
</script>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="noticia_editar" 
    	id="noticia_editar">
    	<fieldset>
        	<legend>Editar Notícia</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" 
                	alt="obrigatorio" value="<?php echo $titulo; ?>" />
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">Subtítulo</strong>
                <textarea name="subtitulo" id="subtitulo" class="textarea full textarea txaTextarea"><?php echo $subtitulo; ?>
                </textarea>
            </label>

            <label class="full lblInputFile">
            	<strong class="legendaCampos">Imagem de Capa<span class="alertaLegenda">*Apenas arquivos .jpg</span>
                </strong>
                <input type="file" id="imgcapa" name="imgcapa" class="full input" />
            </label>
            
            <label id="lblImgCapaDemo" class="lblImgBannerDemo">
                <img src="<?php echo $thumbDemo; ?>" alt="" class="imgDemo" />
                <strong class="legendaCampos"><?php echo substr($thumb, 12); ?></strong>
            </label>
            
            <label class="full halfLabel">
	            <input type="checkbox" id="nao_exibir_thumb" name="nao_exibir_thumb" value="1" <?php echo $naoExibirThumb; ?> />
                	<span class="check">Não exibir imagem de capa na reportagem</span>
            </label>
             
             <label class="lblDestaque">
                 <select name="destaque_post" id="destaque_post" onchange="exibir_Ocultar_Elemento()" >
                    <option value="selecione" <?php echo $selecione; ?>>Sem Destaque</option>
                    <option value="banner" <?php echo $thumbBannerSelecionado; ?>>Banner</option>
                    <option value="video" <?php echo $videoSelecionado; ?>>Vídeo</option>
                </select>
            </label>

            <label id="banner_destaque" style="display:none" class="full lblInputFile">
                <strong class="legendaCampos">Imagem Banner<span class="alertaLegenda">*Apenas arquivos .jpg, .png e .gif</span></strong>
                <input type="file" id="thumb_banner" name="thumb_banner" class="full input" />
            </label>
<?php if(!empty($thumbBannerDemo)){ ?>
			<label id="lblImgBannerDemo" class="lblImgBannerDemo">
                <img src="<?php echo $thumbBannerDemo; ?>" alt="" class="imgDemo" id="imgBannerDemo" />
                <strong class="legendaCampos"><?php echo $thumbBanner; ?></strong>
            </label>
<?php } ?>
            <label id="video_destaque" style="display:none" class="full lblTextarea">
                <strong class="legendaCampos">Vídeo</strong>
                <textarea id="video" name="video" class="full textarea txaTextarea"><?php echo $video; ?></textarea>
            </label>

            <label class="full lblLegendaTexto">
            	<strong class="legendaCampos">Texto</strong>
            </label>
            
            <label class="full lblTexto">
                <textarea id="texto" name="texto" class="mceAdvanced full textarea txaTexto"><?php echo $texto; ?></textarea>
            </label>

			<input type="hidden" id="thumbCapa" name="thumbCapa" value="<?php echo $thumb; ?>" />
            <input type="hidden" id="thumbBunner" name="thumbBunner" value="<?php echo $thumbBanner; ?>" />
			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>