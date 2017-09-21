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
                    
<!DOCTYPE html>
<html>
<head>
	<title>Slideshow javascript</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Made with WOW Slider - Create beautiful, responsive image sliders in a few clicks. Awesome skins and animations. Slideshow javascript" />
	
	<!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
	<link rel="stylesheet" type="text/css" href="engine2/style.css" />
	<script type="text/javascript" src="engine2/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->

</head>
<body>
	
	
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
?>
<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
	<div id="wowslider-container2">
	<div class="ws_images"><ul>
<?php
		$cont = 0;
		$thumbnails = "";
		while($res_galeria_page = mysqli_fetch_array($galeria_page)){
			$thumb = $res_galeria_page[0];
			$legenda = $res_galeria_page[1];
			$thumbnails .="<a href='#wows2_".$cont."' title='".$legenda."'><img src='data2/tooltips/".$thumb."' alt='' /></a> \n";
?>
		<li><img src="data2/images/<?php echo $thumb; ?>" alt="<?php echo $legenda; ?>" title="<?php echo $legenda; ?>" id="wows2_<?php echo $cont; ?>"/></li>
<?php 
			$cont++;
		}
?>
	</ul></div>
	<div class="ws_thumbs">
<div>
<?php echo $thumbnails; ?>
</div>
</div>
<div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">slideshow javascript</a> by WOWSlider.com v8.8</div>
	<div class="ws_shadow"></div>
	</div>	
	<script type="text/javascript" src="engine2/wowslider.js"></script>
	<script type="text/javascript" src="engine2/script.js"></script>
	<!-- End WOWSlider.com BODY section -->
<?php } ?>
</body>
</html>
                    
 




</div>
        	</div>
            
<?php
	include "sidebars/sidebar.php";
	$categoria = 1;
	$id_atual = $id_single;
	$chamada = 'single-sidebar';
	include "scripts/posts.php";
?>