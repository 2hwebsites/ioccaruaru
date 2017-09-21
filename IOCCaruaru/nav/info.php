<?php
	//include $_SERVER['DOCUMENT_ROOT']."/funcoes.php";
	
    $categoria = $_GET['cat'];
	$str_subtitulo = ', ip.subtitulo ';
	
	if($categoria == 1){
		$legenda = 'Galeria';
		$str_subtitulo = '';
	} else if($categoria == 2){		
		$legenda = 'Notícias';
	} else if($categoria == 3){
		$legenda = 'Dicas de Saúde';
	}
	
	
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
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total FROM ioc_posts WHERE ativo = '1' AND categoria_id = '".$categoria."'"));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg);

	/***** fim da paginação  ************************************************************************************/
	
	$sql = "SELECT ip.id, ip.thumb, ip.url_post, ip.titulo, ic.descricao, ip.categoria_id ".$str_subtitulo.
			"FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.categoria_id = '$categoria' AND ativo = '1'
			ORDER BY ip.id DESC 
			LIMIT $inicial, $numreg";
			
	$post = mysqli_query($conn, $sql)
		Or die('Erro ao obter posts. '.mysqli_error($conn));
		
	mysqli_close($conn);
	
	$total_posts = @mysqli_num_rows($post);
	
	if($total_posts == '0'){
		echo "Não há posts cadastrados.";
	}else{
		$cont = 0;
		
		while($res_post = mysqli_fetch_array($post)){
			$cont++;

			$id = $res_post[0];
			$thumb = $res_post[1];
			$url_post = $res_post[2];
			$titulo = $res_post[3];
			$descricao = $res_post[4];
			$categoria_post = $res_post[5];
			
			if($categoria_post <> 1){
				$subtitulo = $res_post[6];
			}
			
			if($cont == 1){
?>
			<div id="page">
				<h1 class="legenda-page"><?php echo $legenda;?></h1>
                
				<div id="info">
					<ul class="info-lista">
<?php
			}
			
			if($cont <= 2){
				$margem = 'info-margem-baixo';
			} else{
				if($cont == 3){
					$margem = 'info-margem-baixo-resp';
				} else{
					$margem = '';
				}
			}
?>
                        
                            <li class="info-linha <?php echo $margem;?> linha<?php echo $cont;?>">
                            <a href="index.php?pagina=nav/<?php echo ($categoria_post == '1' ? 'galeria_' : ''); ?>single&amp;<?php echo 'id=' . $id . '&post=' . $url_post; ?>">
                                <img src="upload/<?php echo $descricao;?>/<?php echo sprintf("%06d", $id); ?><?php echo ($categoria_post <> '1' ? '/img_m' : ''); ?>/<?php echo $thumb;?>" 
                                	alt="<?php echo $titulo; ?>" class="info-img" />
                                <h2 class="info-titulo legenda-<?php echo $descricao;?>"><?php echo $titulo; ?></h2>
<?php
			if($categoria_post <> 1){
				echo '									<p>'.$subtitulo.'</p>';
			}
?>
                        		</a>
                            </li>
                        
<?php
			if($cont == $total_posts){
?>	
                    </ul>
                </div>
<?php
			}
		}
	}
?>
                
                <div style="clear:both;"></div>
                <?php echo paginacao($page, $total, "index.php?pagina=nav/info&cat=".$categoria."&pg="); ?>
                
			</div>
            
<?php 
	include "sidebars/sidebar.php";
	$chamada = 'info-sidebar';
	include "scripts/posts.php";
?>