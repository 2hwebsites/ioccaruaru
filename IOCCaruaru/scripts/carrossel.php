			<div class="wrap-carrossel">
                <div class="carrossel">
                	<img src="img/base-carrossel.png" alt="" class="omite_imgCarrossel" />

                    <div class="slider">
<?php
	require_once "connections/conn.php";
		
	$sql = "SELECT ip.titulo, ip.thumb, ip.url_post, ic.descricao, ip.id
			FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.categoria_id = $categoria 
			ORDER BY ip.id DESC";
	$carrossel = mysqli_query($conn, $sql)
		Or die('Erro ao obter banner. '.mysqli_error($conn));
		
	mysqli_close($conn);
	
	if(@mysqli_num_rows($carrossel) == '0'){
		echo "Não há banners cadastrados";
	} else{
		while($res_carrossel = mysqli_fetch_array($carrossel)){
			$titulo = $res_carrossel[0];
			$thumb = $res_carrossel[1];
			$url_post = $res_carrossel[2];
			$descricao = $res_carrossel[3];
			$id = $res_carrossel[4];

			if(!empty($url_post)){?>
								<a href="<?php echo $url_post; ?>">
<?php echo "	"; }?>
                        		<img src="upload/<?php echo $descricao."/".sprintf("%06d", $id)."/".$thumb; ?>" alt="<?php echo $titulo; ?>" title="<?php echo $titulo; ?>" />
<?php if(!empty($url_post)){?>
								</a>
<?php 		
			}
		}
	}
?>
                    </div>
                    
					<span class="slider-page"></span>
            	</div>
			</div>