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
		echo "Este galeria não está cadastrada!";
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
<?php
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

			$legenda = "Testando 1, 2, 3";

			if($cont == 1){
				$html_row = "\n            		<div class='row'>";
				$html_myModal = "\n					<div id='myModal' class='modal'>
						<span class='close' onclick='closeModal()'>&times;</span>\n
  						<div class='modal-content'>";
				$html_myModal_a = "\n							<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
    						<a class='next' onclick='plusSlides(1)'>&#10095;</a>\n";
				$html_myModal_caption = "\n							<div class='caption-container'>
      							<p id='caption'></p>
    						</div>\n";
				$html_myModal_inline = "\n							<div class='inline'>\n";
				$html_myModal_inline = $html_myModal_inline."								<div class='inline-carrossel'>\n";
							
			}
			
			$html_row = $html_row."\n						<div class='column'>\n";
			$html_row = $html_row."							<img src='upload/galeria/".sprintf("%06d", $id)."/img_p/".$thumb."' onclick='openModal();currentSlide(".$cont.");posicaoInicial(".$cont.");ajustarImagem(".$cont.")' class='img_galeria' />\n";
			$html_row = $html_row."						</div>\n";
			
			$html_myModal = $html_myModal."\n							<div class='mySlides'>\n";
			$html_myModal = $html_myModal."								<div class='numbertext'>".$cont." / ".$total_imagens."</div>\n";
			$html_myModal = $html_myModal."								<img src='upload/galeria/".sprintf("%06d", $id)."/img_g/".$thumb."' class='imgModal".$cont."' />\n";
			$html_myModal = $html_myModal."							</div>\n";

			$html_myModal_inline = $html_myModal_inline."								<div class='imgDemo'>\n";
			$html_myModal_inline = $html_myModal_inline."									<img class='demo' src='upload/galeria/".sprintf("%06d", $id)."/img_m/".$thumb."' onclick='currentSlide(".$cont.");posicaoInicial(".$cont.");ajustarImagem(".$cont.")' alt='".$legenda."'>\n";
			$html_myModal_inline = $html_myModal_inline."								</div>\n";
		}
		
		$html_myModal_inline = $html_myModal_inline."\n								<a class='prevDemo' onclick='antDemo(0, 1)'>&#10094;</a>
    							<a class='nextDemo' onclick='proxDemo(0, 1)'>&#10095;</a>\n";
		$html_row = $html_row."					</div>\n";
		$html_myModal_inline = $html_myModal_inline."								</div>\n";
		$html_myModal_inline = $html_myModal_inline."							</div>\n";
		$html_myModal_fim = "						</div>\n					</div>\n";
		
		echo $html_row.$html_myModal.$html_myModal_a.$html_myModal_caption.$html_myModal_inline.$html_myModal_fim;
	}
?>
            	</div>
        	</div>
            
<?php
	include "sidebars/sidebar.php";
	$categoria = 1;
	$id_atual = $id_single;
	$chamada = 'single-sidebar';
	include "scripts/posts.php";
?>