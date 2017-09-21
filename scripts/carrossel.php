<?php
	include "connections/conn.php";

	$sql = "SELECT titulo, thumb, url_post
			FROM ioc_posts
			WHERE categoria_id = '4' AND ativo = '1'";

	$carrossel = mysqli_query($conn, $sql)
		Or die('Erro ao obter imagens do carrossel.'.mysqli_error($conn));

	$total_imagens = @mysqli_num_rows($carrossel);

	if($total_imagens == '0'){
		echo "Não há imagens do carrossel cadastradas!";
	}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Carrossel</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Made with WOW Slider - Create beautiful, responsive image sliders in a few clicks. Awesome skins and animations. Jquery carousel" />
	
	<!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />
	<script type="text/javascript" src="engine1/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->

</head>
<body style="background-color:#ffffff;margin:0">
	
	<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
	<div id="wowslider-container1">
	<div class="ws_images"><ul>
<?php
		$cont = 0;
		$thumbnails = "";
		while($res_carrossel = mysqli_fetch_array($carrossel)){
			$titulo = $res_carrossel[0];
			$thumb = $res_carrossel[1];
			$url_post = $res_carrossel[2];
			$thumbnails .="<a href='#' title='".$titulo."'><span><img src='data1/tooltips/".$thumb."' alt='".$titulo."'/>".($cont + 1)."</span></a>\n";
			$link = !empty($url_post);
?>
		<li><?php echo ($link ? "<a href='".$url_post."' target='_blank'>" : ""); ?><img src="data1/images/<?php echo $thumb; ?>" alt="<?php echo $titulo; ?>" title="<?php echo $titulo; ?>" id="wows1_<?php echo $cont; ?>"/><?php echo ($link ? "</a>" : ""); ?></li>
<?php
			$cont++;
		}
?>
	</ul></div>
	<div class="ws_bullets"><div>
<?php echo $thumbnails; ?>
	</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">slideshow html code</a> by WOWSlider.com v8.8</div>
	<div class="ws_shadow"></div>
	</div>	
	<script type="text/javascript" src="engine1/wowslider.js"></script>
	<script type="text/javascript" src="engine1/script.js"></script>
	<!-- End WOWSlider.com BODY section -->

</body>
</html>
<?php } ?>