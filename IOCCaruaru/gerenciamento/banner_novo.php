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
		$thumb = date("dmyHis").$_FILES['imgcapa']['name'];
		$thumbTmp = $_FILES['imgcapa']['tmp_name'];
		$urlPost = $_POST["url"];
		
		$campos = array(
					0 => "titulo",
					1 => "data",
					2 => "thumb", 
					3 => "url_post",
					4 => "categoria_id",
					5 => "usuario_id");
					
		$valores = array(
					0 => "'".$titulo."'",
					1 => "'".$data."'",
					2 => "'".$thumb."'",
					3 => "'".$urlPost."'",
					4 => '5',
					5 => "'".$usuario['id']."'");

		if($id = InserirDados($campos, $valores, "ioc_posts")){
			$path = "../upload/banner/".sprintf("%06d", $id);
			
			// Cria os diretórios, se não existir
			if(!file_exists($path)){
				mkdir($path);
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
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=banners&cat=5&us=".$usuario['id']."'>";
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
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="banner_novo" id="banner_novo">
    	<fieldset>
        	<legend>Cadastrar Banner</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" 
                	alt="obrigatorio" />
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