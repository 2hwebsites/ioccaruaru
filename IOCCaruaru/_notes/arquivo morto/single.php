            <div id="page">
                <div id="single">
    
<?php
	$topico = $_GET['topico'];
	$id_single = substr($topico, 3, strpos($topico, ';')-3);
	$url_title = substr($topico, strpos($topico, ';')+6);
	
	include "connections/conn.php";
	
	$sql = "SELECT ip.titulo, ip.data, ip.subtitulo, ip.thumb, ip.nao_exibir_thumb, ip.thumb_banner, ip.video, ip.texto,  
			ip.autor, ip.categoria_id, ic.descricao
			FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.id = '$id_single' AND ip.url_post = '$url_title' AND ip.ativo = '1'";

	$single_page = mysqli_query($conn, $sql)
		Or die('Erro ao obter post.'.mysqli_error($conn));
		
	mysqli_close($conn);
		
	if(@mysqli_num_rows($single_page) == '0'){
		echo "Este post não está cadastrado ou foi excluído.";
	}else{
		$cont = 0;
		
		while($res_single_page = mysqli_fetch_array($single_page)){
			$titulo = $res_single_page[0];
			$data = $res_single_page[1];
			$subtitulo = $res_single_page[2];
			$thumb = $res_single_page[3];
			$naoExibirThumb = $res_single_page[4];
			$thumb_banner = $res_single_page[5];
			$video = $res_single_page[6];
			$texto = $res_single_page[7];
			$autor = $res_single_page[8];
			$post_categoria = $res_single_page[9];
			$descricao = $res_single_page[10];
				
?>
            		<h1 class="titulo-single legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h1>
            		<h2 class="subtitulo-single"><?php echo $subtitulo; ?></h2>
            		<h6 class="autor-sigle"><?php echo 'Por '.$autor.' - '.date('d/m/Y - H:i', strtotime($data)); ?></h6>
<?php 		if($thumb_banner <> ''){ ?>
				<div id="banner_single">
                	<img src="upload/<?php echo $descricao; ?>/<?php echo sprintf("%06d", $id_single); ?>/banner/<?php 
						echo $thumb_banner; ?>" alt="<?php echo $titulo; ?>" class="banner-single" />
                </div>
                <div style="clear:both;"></div>
<?php 		}elseif($video <> ''){echo $video;}
 	  
	  		if($thumb <> '' && $naoExibirThumb == 0){ 
	  	  		$texto =  strstr($texto, "</p>", true)."<img src='upload/".$descricao."/".sprintf("%06d", $id_single)."/img_g/".$thumb.
							"' alt='".$titulo."' class='img-single' />".strstr($texto, "</p>");
	  		} 
		
			echo $texto;
		}
	}
?>
					<div class="fb-share-button" data-layout="button" data-size="large" data-mobile-iframe="true">
                    	<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">Compartilhar</a></div>
            	</div>
        	</div>
<?php
	include "sidebars/sidebar.php";
	$categoria = $post_categoria;
	$id_atual = $id_single;
	$chamada = 'single-sidebar';
	include "scripts/posts.php";
?>
</div>