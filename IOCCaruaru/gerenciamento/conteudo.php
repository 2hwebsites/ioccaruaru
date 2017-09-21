<?php	
	//inicializa as variáveis
	$cat = '';
	$id = '';
	$categoria = '';
	$categoriaNome = '';
	$categoriaPath = '';
	$acao = '';
	$descAcao = '';
	$optSelecione = 'selected';
	$optBanner = '';
	$optVideo = '';
	$titulo = '';
	$data = '';
	$subtitulo = '';
	$thumb = '';
	$thumb_banner = '';
	$video = '';
	$texto = '';
	$url_post = '';
	$autor= '';
	$usuario_id = '';
	$imgCapa = '';
	$imgCapaAntiga = '';
	$imgCapaTmp = '';
	$ajustarImagemCapa = 1;
	$naoExibirThumb = 0;
	$naoExibirThumbCheck = '';
	$imgBanner = '';
	$imgBannerAntigo = ''; 
	$imgBannerTmp = '';
	$ajustarImagemBanner = 0;
	$sqlPost = '';
	$id_post = '';
	$path = '';
	$oImg = '';
	$valida = '';
	
	if(isset($_GET['cat'])){
		$cat = $_GET['cat'];
	}
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	include "../connections/conn.php";
	$categoria = mysqli_fetch_assoc(mysqli_query($conn, "select * from ioc_categoria where id='$_GET[cat]'"));
	
	$categoriaNome = $categoria['nome'];
	$categoriaPath = $categoria['descricao'];
	
	switch($categoria['id']){			
		case 2:		// Notícias
			$categoriaNome = 'Notícia';
			break;
			
		case 3:		// Dicas de Saúde
			$categoriaNome = 'Dica de Saúde';
			break;
	}
	
	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];
		$descAcao = ($acao == 1 ? 'Inserir' : 'Alterar');
		
		if($acao == 2){ 	// Alterar
			$post_sql = mysqli_query($conn, "SELECT titulo, data, subtitulo, thumb, thumb_banner, video, texto, url_post
											FROM ioc_posts	 WHERE id = '$id'") 
							Or die('Erro ao obter post para edição. '.mysqli_error($conn));
			
			$res_post_sql = mysqli_fetch_array($post_sql);
			
			$titulo = $res_post_sql[0];
			$data = $res_post_sql[1];
			$subtitulo = $res_post_sql[2];
			$thumb = $res_post_sql[3];
			$thumb_banner = $res_post_sql[4];
			$video = $res_post_sql[5];
			$texto = $res_post_sql[6];
			$url_post = $res_post_sql[7];
			
			if(!empty($thumb_banner)){
				$optBanner = 'selected';
			}elseif(!empty($video)){
				$optVideo = 'selected';
			}else{
				$optSelecione = 'selected';
			}
			
			if($naoExibirThumb == 1){
				$naoExibirThumbCheck = 'checked';
			}
		}
	}
	
	mysqli_close($conn);
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		// Título
		$titulo = $_POST['titulo'];
		
		// Data
		//if(ValidaData(@$_POST['data'])){
			//$data = converte_data($_POST['data']);
			$data = $_POST['data'];
		//}else{
			//$data = date("Y-m-d");
		//}
		
		// Imagem de Capa
		if(!empty($_FILES["thumb"]["name"])){
			//$imgCapa = date("dmyHms").$_FILES["thumb"]["name"];
			$imgCapa = $_FILES["thumb"]["name"];
			
			
			$imgCapaTmp = $_FILES["thumb"]["tmp_name"];
			$ajustarImagemCapa = 1;
			
			if(!empty($thumb) && $acao == 2){
				$imgCapaAntiga = $thumb;
			}
		}else{
			$imgCapa = $thumb;
			$ajustarImagemCapa = 0;
		}
		
		// Não exibir imagem de capa na reportagem
		if(isset($_POST['nao_exibir_thumb'])){
			$naoExibirThumb = $_POST['nao_exibir_thumb'];
		}
		
		// Notícias ou Dicas de Saúde
		if($cat == 2 || $cat == 3){		
			// Subtítulo
			$subtitulo = $_POST['subtitulo'];
			
			// Imagem Banner
			if($_POST['destaque_post'] == "banner"){
				$video = '';

				if(!empty($_FILES["thumb_banner"]["name"])){
					$imgBanner = date("dmyHms").$_FILES["thumb_banner"]["name"]; 
					$imgBannerTmp = $_FILES["thumb_banner"]["tmp_name"];
					$ajustarImagemBanner = 1;
					
					if(!empty($thumb_banner)){
						$imgBannerAntigo = $thumb_banner;
					}
				}else{
					$imgBanner = $thumb_banner;
					$ajustarImagemBanner = 0;
				}
			// Vídeo
			}elseif($_POST['destaque_post'] == "video"){
				$imgBanner = '';
				$ajustarImagemBanner = 0;
				$video = $_POST['video'];
			// Nenhuma das opções
			}else{
				$imgBanner = '';
				$ajustarImagemBanner = 0;
				$video = '';
			}

			// Texto
			$texto = $_POST['texto'];
		}else{
			$subtitulo = '';
			$imgBanner = '';
			$video = '';
			$texto = '';
		}
		
		// Galeria, Notícias ou Dicas de Saúde
		if($cat <= 3){
			// Url do Post
			// Remove caracteres especiais, acentos e coloca todas as letras em minúsculas
			$url_post = preg_replace("/[^a-zA-Z0-9 ]/", "", strtolower(removeAcentos($_POST["titulo"])));
			// substitui espaços em branco por hífen(-)
			$url_post = preg_replace('/[ -]+/', '-', $url_post);
			
		}else{
			$url_post = $_POST["url_post"];
		}

		// Autor
		$autor = $_SESSION['usuario']['nome_resumido'];
		
		// Usuário
		$usuario_id = $_SESSION['usuario']['id'];

		include "../connections/conn.php";
		
		if($acao == 1){
			//insere o post no banco
			$sqlPost = mysqli_query($conn, "INSERT INTO ioc_posts(titulo, data, subtitulo, thumb, nao_exibir_thumb, thumb_banner, video, texto, url_post,
										autor, categoria_id, usuario_id)
										VALUES('$titulo', '$data', '$subtitulo', '$imgCapa', $naoExibirThumb, '$imgBanner', '$video', '$texto', 
										'$url_post', '$autor', '$cat', '$usuario_id')")
										Or die('Erro ao inserir post. '.mysqli_error($conn));
			
			$id_post = mysqli_fetch_assoc(mysqli_query($conn, "select max(id) AS id from ioc_posts"));
			$id = $id_post['id'];
		}elseif($acao == 2){
			//insere o post no banco
			$sqlPost = mysqli_query($conn, "UPDATE ioc_posts SET titulo = '$titulo', data = '$data', subtitulo = '$subtitulo', thumb = '$imgCapa', 
											nao_exibir_thumb = '$naoExibirThumb', thumb_banner = '$imgBanner', video = '$video', texto = '$texto', 
											url_post = '$url_post', autor = '$autor', usuario_id = '$usuario_id' 
											WHERE id = '$id'")
										Or die('Erro ao editar post. '.mysqli_error($conn));
		}
		
		mysqli_close($conn);

	 	// Ajusta tamanho da imagem de capa
	 	if($sqlPost && $ajustarImagemCapa){
			if($cat <= 3){
				if(!file_exists("../upload/".$categoriaPath."/".$id)){
					mkdir("../upload/".$categoriaPath."/".$id);
				}
				if(!file_exists("../upload/".$categoriaPath."/".$id."/img_g")){
					mkdir("../upload/".$categoriaPath."/".$id."/img_g");
				}
			
				$path = "../upload/".$categoriaPath."/".$id."/img_g/".$imgCapa;
				
				// Exclui imagem anterior
				if(!empty($imgCapaAntiga) && file_exists("../upload/".$categoriaPath."/".$id."/img_g/".$imgCapaAntiga)){
					unlink("../upload/".$categoriaPath."/".$id."/img_g/".$imgCapaAntiga);
				}
			}
			
			if($cat == 1){	// Galeria
				geraImg($imgCapaTmp, 800, 450, $path, 90);
			}elseif($cat == 2 || $cat == 3){	// Notícias ou Dicas de Saúde
				geraImg($imgCapaTmp, 400, 400, $path, 90);
			}
			
			if($cat < 6){
				// instancia objeto m2brimagem QUE REDIMENSIONA SEM CORTAR
				include_once "m2brimagem.class.0.6.2.php";
				
				// Redimenciona a imagem para tamanho médio.
				if($cat <= 3){		// Galeria, Notícias ou Dicas de Saúde
					$path = "../upload/".$categoriaPath."/".$id;
					
					// Exclui imagem anterior média
					if(!empty($imgCapaAntiga) && file_exists($path."/img_m/".$imgCapaAntiga)){
						unlink($path."/img_m/".$imgCapaAntiga);
					}
					
					// Exclui imagem anterior pequena
					if(!empty($imgCapaAntiga) && file_exists($path."/img_p/".$imgCapaAntiga)){
						unlink($path."/img_p/".$imgCapaAntiga);
					}
					
					// Cria diretório da imagem média
					if(!file_exists($path."/img_m")){
						mkdir($path."/img_m");
					}
					
					// Cria diretório da imagem pequena
					if(!file_exists($path."/img_p")){
						mkdir($path."/img_p");
					}
					
					$pathTmp = "../upload/tmp/";
					
					if(!move_uploaded_file($imgCapaTmp, $pathTmp.$imgCapa)){
						$msg[] = "<b>$imgCapa : </b> Ocorreu um erro ao copiar a imagem!";
					}
					
					$imgTmp = $pathTmp.$imgCapa;
					
					$oImg = new m2brimagem($imgTmp);
					$valida = $oImg->valida();
					
					if($valida == 'OK'){
						$oImg->redimensiona(250,150,'');
						$imgCapaM = $path."/img_m/".$imgCapa;
						$oImg->grava($imgCapaM);
					} else {
						// mensagem de erro
						die($valida);
					}
					
					$oImg = new m2brimagem($imgTmp);
					$valida = $oImg->valida();
					
					if($valida == 'OK'){
						$oImg->redimensiona(140,95,'');
						$imgCapaP = $path."/img_p/".$imgCapa;
						$oImg->grava($imgCapaP);
					} else {
						// mensagem de erro
						die($valida);
					}
				}else{
					$path = "../upload/".$categoriaPath;
					
					if($cat == 4){		// Carrossel
						// Exclui imagem anterior
						if(!empty($imgCapaAntiga) && file_exists($path."/".$imgCapaAntiga)){
							unlink($path."/".$imgCapaAntiga);
						}
						
						$imgCapaCarrossel = $path."/".$imgCapa;
						
						$oImg = new m2brimagem($imgCapaCarrossel);
						$valida = $oImg->valida();
						
						if($valida == 'OK'){
							$oImg->redimensiona(1024,300,'');
							$oImg->grava($imgCapaCarrossel);
						} else {
							// mensagem de erro
							die($valida);
						}
					}
					
					if($cat == 5){		// Banner
						// Exclui imagem anterior
						if(!empty($imgCapaAntiga) && file_exists($path."/".$imgCapaAntiga)){
							unlink($path."/".$imgCapaAntiga);
						}
						
						$imgCapaPropaganda = $path."/".$imgCapa;
						
						$oImg = new m2brimagem($imgCapaPropaganda);
						$valida = $oImg->valida();
						
						if($valida == 'OK'){
							$oImg->redimensiona(330,165,'');
							$oImg->grava($imgCapaPropaganda);
						} else {
							// mensagem de erro
							die($valida);
						}
					}
				}
			}
		}
		
		// Ajusta tamanho do banner das Notícias ou Dicas de Saúde
		if($sqlPost && $ajustarImagemBanner){
			if(!file_exists("../upload/".$categoriaPath."/".$id."/banner")){
				mkdir("../upload/".$categoriaPath."/".$id."/banner");
			}
			$path = "../upload/".$categoriaPath."/".$id."/banner/".$imgBanner;
			geraImg($imgBannerTmp, 450, 450, $path, 90);
			
			// Exclui imagem anterior
			if(!empty($imgCapaAntiga) && file_exists("../upload/".$categoriaPath."/".$id."/banner/".$imgBannerAntigo)){
				unlink("../upload/".$categoriaPath."/".$id."/banner/".$imgBannerAntigo);
			}
		}
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?pagina=conteudo_postados&cat=".$cat."'>";
		//redireciona("index.php?pagina=conteudo_postados&cat='$cat'");
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
        content_css: "css/development.css",
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
    
    function novaJanela(){
        var opcoes = "menubar=no,toolbar=no,width=500";
        Variavel = window.open ("imagens.php", "Nome da janela", opcoes) ;
    }
</script>

<script>
	$(document).ready(function(){
		exibir_Ocultar_Elemento()
	});
	
	function validaData(campo,valor){
		var date = valor;
		var ardt = new Array;
		var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
		ardt = date.split("/");
		erro = false;
		
		if (date || date.length != 0){
			if (date.search(ExpReg) == -1){
				erro = true;
			}
			else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30)){
				erro = true;
			}
			else if (ardt[1] == 2){
				if ((ardt[0] > 28) && ((ardt[2]%4) != 0)){
					erro = true;
				}
				if ((ardt[0] > 29) && ((ardt[2]%4) == 0)){
					erro = true;
				}
			}
		}
		
		if (erro){
			alert(valor + " não é uma data válida!");
			campo.focus();
			campo.value = "";
			return false;
		}
		
		return true;
	}
</script>

	<form onSubmit="return critica_conteudo(this);" action ="" method="post" enctype="multipart/form-data" name="novo" id="novo">
    	<fieldset>
        	<legend><?php echo $descAcao." ".$categoriaNome; ?></legend>
        	
            <label>
            	<span class="legenda-titulo">Título</span>
                <div id="msgTitulo"></div>
            	<span class="legenda-data">Data</span>
            </label>
            
            <label>
            	<input type="text" id="titulo" name="titulo" maxlength="100" value="<?php echo $titulo; ?>" class="campo-titulo" />
            	<input type="text" id="data" name="data" maxlength="19" value="<?php echo ($acao == 1 ? date('d/m/Y') : date('d/m/Y', strtotime($data))); ?>" onkeypress="formatar('####/##/## ##:##:##', this); return SomenteNumero(event)"  />
            </label>
<?php if($cat >= 4){?>
			<label>
            	<span>URL</span>
            	<textarea id="url_post" name="url_post" ><?php echo $url_post; ?></textarea>
            </label>
<?php }?>
<?php if($cat == 2 || $cat == 3){?>
			<label>
            	<span>Subtítulo</span>
            	<textarea id="subtitulo" name="subtitulo" ><?php echo $subtitulo; ?></textarea>
            </label>
<?php }?>
            <label>
            	<span>Imagem de Capa</span>
<?php if($cat <> 6){ ?>
            	<input type="file" id="thumb" name="thumb" />
<?php if($cat > 1){ ?>
                <input type="checkbox" id="nao_exibir_thumb" name="nao_exibir_thumb" value="1" <?php echo $naoExibirThumbCheck ?> /><span class="check">Não exibir imagem de capa na reportagem</span>
<?php }}else{?>
				<textarea id="thumb_revista" name="thumb_revista" ><?php echo $thumb; ?></textarea>
<?php }
	  if($acao <> 1 && $cat <> 6){?>
				<img src="../upload/<?php echo $categoriaPath; ?>/<?php echo $id; ?>/img_p/<?php echo $thumb; ?>" alt="" />
                <p><?php echo $thumb; ?></p>
<?php }?>
            </label>
<?php if($cat == 1){?>
			<label>
            	<span>Imagens da Galeria</span>
            	<input type="file" id="galeria" name="galeria[]" multiple />
            </label>
<?php }?>
<?php if($cat == 2 || $cat == 3){?>
			<span>Destaque</span>
			<select name="destaque_post" id="destaque_post" onchange="exibir_Ocultar_Elemento()" >
            	<option value="selecione" <?php echo $optSelecione; ?>>Sem Destaque</option>
                <option value="banner" <?php echo $optBanner; ?>>Banner</option>
                <option value="video" <?php echo $optVideo; ?>>Vídeo</option>
            </select>

            <label id="banner_destaque" style="display:none">
                <span>Imagem Banner</span>
                <input type="file" id="thumb_banner" name="thumb_banner" />
<?php if($acao <> 1 && !empty($thumb_banner)){?>
				<img src="../upload/<?php echo $categoriaPath; ?>/<?php echo $id; ?>/banner/<?php echo $thumb_banner; ?>" alt="" />
                <p><?php echo $thumb_banner; ?></p>
<?php }?>	
            </label>
            
            <label id="video_destaque" style="display:none">
                <span>Vídeo</span>
                <textarea id="video" name="video" ><?php echo $video; ?></textarea>
            </label>
            
            <label>
            	<span>Texto</span>
            	<textarea id="texto" name="texto" class="mceAdvanced"><?php echo $texto; ?></textarea>
            </label>
<?php }?>
			<input name="publicar" type="submit" id="publicar" value="Publicar Conteúdo" />
        </fieldset>
    </form>