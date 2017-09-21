<?php
	$id_single = $_GET['id'];
	$url_title = $_GET['post'];

	include "connections/conn.php";

	$sql = "SELECT ip.id, ip.titulo, ic.descricao
			FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.id = '$id_single' AND ip.url_post = '$url_title'";

	$single_page = mysqli_query($conn, $sql)
		Or die('Erro ao obter galeria.'.mysqli_error($conn));

	if(@mysqli_num_rows($single_page) == '0'){
		echo "Esta galeria não está cadastrada!";
	}else{
		$res_single_page = mysqli_fetch_array($single_page);
		
		$id = $res_single_page[0];
		$titulo = $res_single_page[1];
		$descricao = $res_single_page[2];
	}
?>
			<div id="page">
                <div id="single">
					<h1 class="titulo-single legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h1>
                    	<ul id="album-fotos">
<?php
	include "wowgaleria.php";
	$sql = "SELECT ig.thumb, ig.legenda
			FROM ioc_galeria AS ig 
			INNER JOIN ioc_posts AS ip ON ig.posts_id = ip.id
			WHERE ip.id = '$id' AND ip.url_post = '$url_title'";
			
	$galeria_page = mysqli_query($conn, $sql) Or die('Erro ao obter imagens da galeria.'.mysqli_error($conn));
	
	mysqli_close($conn);
	
	$total_imagens = @mysqli_num_rows($galeria_page);

	if($total_imagens == '0'){
		echo "As imagens desta galeria não estão cadastradas!";
	}else{
		$cont = 0;
		$html_row = '';
		$html_myModal = '';
		$html_myModal_a = '';
		$html_myModal_caption = '';
		$html_myModal_column = '';
		$html_myModal_fim = '';

		while($res_galeria_page = mysqli_fetch_array($galeria_page)){
			$cont++;
			
			$thumb = $res_galeria_page[0];
			$legenda = $res_galeria_page[1];
?>
				<li id="fotos" style="background:url('<?php echo "upload/galeria/".sprintf("%06d", $id)."/img_g/".$thumb; ?>') no-repeat;"><?php echo $legenda; ?></li>
<?php
		}
	}
?>
					</ul>
            	</div>
        	</div>
            
<?php
	include "sidebars/sidebar.php";
	$categoria = 1;
	$id_atual = $id_single;
	$chamada = 'single-sidebar';
	include "scripts/posts.php";
?>