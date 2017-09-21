<?php	
	/*** inicio da paginação  ************************************************************************************/
	
	$numreg = 4; //registros por pagina
	
	//Obtem pagina atual
	$page = 1;
	
	if (isset($_GET['pg'])){
		$page = $_GET['pg'];
	}
	
	$inicial = ($page - 1) * $numreg;

	include "connections/conn.php";
	
	// Obtem numero total de paginas para paginação
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total FROM ioc_posts WHERE ativo = '1' AND categoria_id = '6'"));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg);

	/***** fim da paginação  ************************************************************************************/
	
	include "connections/conn.php";
	
	$sql = "SELECT id, titulo, thumb, url_post FROM ioc_posts WHERE categoria_id = '6' AND ativo = '1' ORDER BY id DESC LIMIT $inicial, $numreg";

	$revistas = mysqli_query($conn, $sql)
		Or die('Erro ao obter as revistas. '.mysqli_error($conn));
	
	$total_revistas = @mysqli_num_rows($revistas);
	
	if($total_revistas == '0'){
		echo "Não há posts cadastrados.";
	}else{
		$cont = 0;
		
		while($res_revistas = mysqli_fetch_array($revistas)){
			$cont++;

			$id = $res_revistas[0];
			$titulo = $res_revistas[1];
			$thumb = $res_revistas[2];
			$url_post = $res_revistas[3];
			
			
			if($cont == 1){
?>

            <div id="page">
                <h1 class="legenda-page">Revista</h1>

    			<div id="revista">
					<ul class="revista-lista">
<?php
			}
			
			if($cont <= 2){
				$margem = 'info-margem-baixo';
			} else{
				$margem = '';
			}
			
?>
						<li class="revista-linha <?php echo $margem;?>"><a href="<?php echo $url_post;?>" target="_blank"><img src="<?php echo $thumb;?>" /><h2 class="revista-titulo"><?php echo $titulo; ?></h2></a></li>
<?php
			if($cont == $total_revistas){
?>	
                    </ul>
                </div>
<?php
			}
		}
	}
?>
				<div style="clear:both;">
                    <?php echo paginacao($page, $total, "index.php?pagina=nav/revista&cat='6'&pg="); ?>
                </div>   
			</div>

<?php 
	include "sidebars/sidebar.php";
	$chamada = 'page-sidebar';
	
	for($i = 1; $i <= 3; $i++){
		$categoria = $i;
		include "scripts/posts.php";
	}
?>