			<div id="sidebar">
<?php	
	include "connections/conn.php";
	
	$sql = "SELECT id, titulo, thumb, url_post FROM ioc_posts WHERE categoria_id = '5' AND ativo = '1'";
	$banner = mysqli_query($conn, $sql)
		Or die('Erro ao obter banner. '.mysqli_error($conn));
	
	mysqli_close($conn);
	
	if(@mysqli_num_rows == '0'){
		echo "Não há banners cadastrados";
	} else{
		$banners = array();
		$ids = array();
		$cont = 0;
		while($res_banner = mysqli_fetch_array($banner)){
			$ids[$cont] = $res_banner[0];
			$banners['id'][$cont] = $res_banner[0];
			$banners['titulo'][$cont] = $res_banner[1];
			$banners['thumb'][$cont] = $res_banner[2];
			$banners['url'][$cont] = $res_banner[3];
			
			$cont++;
		}
		
		$indice = array_rand($ids);
	}
?>
                <div id="banner">
                    <a href="<?php echo $banners['url'][$indice]; ?>" target="_self"><img src="upload/banner/<?php echo sprintf("%06d", $banners['id'][$indice])."/".$banners['thumb'][$indice]; ?>" alt="<?php echo $banners['titulo'][$indice]; ?>" title="<?php echo $banners['titulo'][$indice]; ?>" /></a>
                </div>

                <div id="informacao-sidebar">
                    <h1>Mais Recentes</h1>
                    
                    <ul>
