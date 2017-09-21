<?php
if(isset($_GET['id'])){
	$id = $_GET['id'];
}
	
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

	AlterarDados($campos, $valores, "ioc_posts", $id);
		
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=revistas&cat=6&us=".$usuario['id']."'>";
}

include "../connections/conn.php";

$res_noticia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT titulo, thumb, url_post From ioc_posts WHERE id = '".$id."'"));
mysqli_close($conn);
	
$titulo = $res_noticia['titulo'];
$thumb = $res_noticia['thumb'];
$url = $res_noticia['url_post'];

?>
	<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="revista_editar" id="revista_editar">
    	<fieldset>
        	<legend>Alterar Revista</legend>
            
            <label class="full">
            	<strong class="legendaCampos">Título</strong>
            	<input type="text" id="titulo" name="titulo" maxlength="100" class="full input" autofocus="autofocus" alt="obrigatorio" value="<?php echo $titulo; ?>" />
            </label>

            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL Imagem Capa</strong>
                <textarea id="url_capa" name="url_capa" class="full textarea txaTextarea"><?php echo $thumb; ?></textarea>
            </label>
            
            <label class="full lblTextarea">
            	<strong class="legendaCampos">URL Revista</strong>
                <textarea id="url" name="url" class="full textarea txaTextarea"><?php echo $url; ?></textarea>
            </label>
            
			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>