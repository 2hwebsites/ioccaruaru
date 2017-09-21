<?php	
	//inicializa as variáveis
	$id = '';
	$titulo = '';
	$data = '';
	$subtitulo = '';
	$thumb = '';
	$thumbTmp = '';
	$texto = '';
	$naoExibirThumb = 0;
	$thumbBanner = '';
	$thumbBannerTmp = '';
	$video = '';
	$campos = '';
	$valores = '';
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$titulo = $_POST['titulo'];
		$data = date("Y-m-d H:i:s");
		$subtitulo = $_POST['subtitulo'];
		$thumb = date("dmyHis").$_FILES['imgcapa']['name'];
		$thumbTmp = $_FILES['imgcapa']['tmp_name'];		
		
		$texto = $_POST['texto'];
		$urlPost = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($_POST["titulo"])));
		$urlPost = preg_replace('/[ -]+/', '-', $urlPost);
		$autor = $usuario['nome_resumido'];
		
		if(isset($_POST['nao_exibir_thumb'])){
			$naoExibirThumb = $_POST['nao_exibir_thumb'];
		}
		
		if($_POST['destaque_post'] == "banner"){
			$thumbBanner = date("dmyHis").$_FILES['thumb_banner']['name'];
			$thumbBannerTmp = $_FILES['thumb_banner']['tmp_name'];
		}
		
		if($_POST['destaque_post'] == "video"){
			$video = $_POST['video'];
		}
		
		$campos = array(
					0 => "titulo",
					1 => "data",
					2 => "subtitulo", 
					3 => "thumb", 
					4 => "nao_exibir_thumb", 
					5 => "thumb_banner",
					6 => "video",
					7 => "texto",
					8 => "url_post",
					9 => "autor",
					10 => "categoria_id",
					11 => "usuario_id");
					
		$valores = array(
					0 => "'".$titulo."'",
					1 => "'".$data."'",
					2 => "'".$subtitulo."'",
					3 => "'".$thumb."'",
					4 => "'".$naoExibirThumb."'",
					5 => "'".$thumbBanner."'",
					6 => "'".$video."'",
					7 => "'".$texto."'",
					8 => "'".$urlPost."'",
					9 => "'".$autor."'",
					10 => '2',
					11 => "'".$usuario['id']."'");

		if($id = InserirDados($campos, $valores, "ioc_posts")){
			$path = "../upload/noticias/".sprintf("%06d", $id);
			
			// Cria os diretórios, se não existir
			if(!file_exists($path)){
				mkdir($path);
			}
			
			if(!file_exists($path."/img_p")){
				mkdir($path."/img_p");
			}
			
			if(!file_exists($path."/img_m")){
				mkdir($path."/img_m");
			}
			
			if(!file_exists($path."/img_g")){
				mkdir($path."/img_g");
			}
			
			// Envia a imagem para a pasta temporária do servidor
			$pathTmp = "../upload/tmp/".$thumb;
			
			if(!move_uploaded_file($thumbTmp, $pathTmp)){
				$msg[] = "<b>$imgCapa : </b> Ocorreu um erro ao copiar a imagem!";
			}
			
			// Gera a imagem grande
			geraImg($pathTmp, 400, 400, $path."/img_g/".$thumb, 90);
			
			// instancia objeto m2brimagem QUE REDIMENSIONA SEM CORTAR
			include_once "m2brimagem.class.0.6.2.php";
			
			// Gera a imagem média
			$oImg = new m2brimagem($pathTmp);
			$valida = $oImg->valida();
			
			if($valida == 'OK'){
				$oImg->redimensiona(250,150,'');
				$thumbM = $path."/img_m/".$thumb;
				$oImg->grava($thumbM);
			} else {
				// mensagem de erro
				die($valida);
			}
			
			// Gera a imagem pequena
			$oImg = new m2brimagem($pathTmp);
			$valida = $oImg->valida();
			
			if($valida == 'OK'){
				$oImg->redimensiona(140,95,'');
				$thumbP = $path."/img_p/".$thumb;
				$oImg->grava($thumbP);
			} else {
				// mensagem de erro
				die($valida);
			}
			
			// Remove o arquivo base da pasta temporária
			if(file_exists($pathTmp)){
				unlink($pathTmp);
			}
			
			// Envia ao servidor a imagem banner
			if($_POST['destaque_post'] == "banner"){
				$path = "../upload/noticias/".sprintf("%06d", $id)."/banner/";
				
				if(!file_exists($path)){
					mkdir($path);
				}

				geraImg($thumbBannerTmp, 450, 450, $path.$thumbBanner, 90);
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=noticias&cat=2&us=".$usuario['id']."'>";
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
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="noticia_novo" id="noticia_novo">
    	<fieldset>
        	<legend>Cadastrar Notícia</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" alt="obrigatorio" />
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">Subtítulo</strong>
                <textarea name="subtitulo" id="subtitulo" class="full textarea txaTextarea"></textarea>
            </label>

            <label class="full">
            	<strong class="legendaCampos">Imagem de Capa<span class="alertaLegenda">*Apenas arquivos .jpg</span></strong>
                <input type="file" id="imgcapa" name="imgcapa" class="full input" alt="obrigatorio" />    
            </label>
            
             <label class="full halfLabel">
             	<input type="checkbox" id="nao_exibir_thumb" name="nao_exibir_thumb" value="1" /><span class="check">Não exibir imagem de capa na reportagem</span>
             </label>
             
             <label class="full lblDestaque">
                 <select name="destaque_post" id="destaque_post" onchange="exibir_Ocultar_Elemento()" >
                    <option value="selecione">Sem Destaque</option>
                    <option value="banner">Banner</option>
                    <option value="video">Vídeo</option>
                </select>
            </label>

            <label id="banner_destaque" style="display:none" class="full">
                <strong class="legendaCampos">Imagem Banner<span class="alertaLegenda">*Apenas arquivos .jpg, .png e .gif</span></strong>
                <input type="file" id="thumb_banner" name="thumb_banner" class="full input" alt="obrigatorio" />
            </label>
            
            <label id="video_destaque" style="display:none" class="full lblTextarea">
                <strong class="legendaCampos">Vídeo</strong>
                <textarea id="video" name="video" class="full textarea txaTextarea"></textarea>
            </label>
            
            <label class="full lblLegendaTexto">
            	<strong class="legendaCampos">Texto</strong>
            </label>
            
            <label class="full lblTexto">
            	<textarea id="texto" name="texto" class="mceAdvanced full textarea txaTexto"></textarea>
            </label>

			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>