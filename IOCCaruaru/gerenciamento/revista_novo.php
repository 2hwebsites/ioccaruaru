<?php	
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$titulo = $_POST['titulo'];
	$data = date("Y-m-d H:i:s");
	$thumb = $_POST["url_capa"];
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
				4 => '6',
				5 => "'".$usuario['id']."'");

	InserirDados($campos, $valores, "ioc_posts");
		
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=revistas&cat=6&us=".$usuario['id']."'>";
}
?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="revista_novo" id="revista_novo">
    	<fieldset>
        	<legend>Cadastrar Revista</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" alt="obrigatorio" />
            </label>

            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL Imagem Capa</strong>
                <textarea id="url_capa" name="url_capa" class="full textarea txaTextarea"></textarea>
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL Revista</strong>
                <textarea id="url" name="url" class="full textarea txaTextarea"></textarea>
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar" class="cadastrar_btn" />
        </fieldset>
    </form>