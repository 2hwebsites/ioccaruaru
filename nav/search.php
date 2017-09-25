			
           	<div id="page">
<?php
	if(isset($_GET['pesquisa'])){
		$pesquisa = $_GET['pesquisa'];
	} else{
    	$pesquisa = $_POST['pesquisa'];
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
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total FROM ioc_posts ip WHERE ativo = '1' AND (ip.titulo REGEXP '[[:<:]]".$pesquisa."[[:>:]]' OR ip.subtitulo REGEXP '[[:<:]]".$pesquisa."[[:>:]]' OR ip.texto REGEXP '[[:<:]]".$pesquisa."[[:>:]]') AND ip.categoria_id <= 3"));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg);

	/***** fim da paginação  ************************************************************************************/
	
	include "connections/conn.php";
	
	$sql = "SELECT ip.id, ip.thumb, ip.url_post, ip.titulo, ic.descricao, ip.categoria_id, ip.subtitulo, ip.texto
			FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE (ip.titulo REGEXP '[[:<:]]".$pesquisa."[[:>:]]' OR
				  ip.subtitulo REGEXP '[[:<:]]".$pesquisa."[[:>:]]' OR
				  ip.texto REGEXP '[[:<:]]".$pesquisa."[[:>:]]') AND
				  ip.categoria_id <= 3 AND
				  ip.ativo = '1' 
			ORDER BY ip.id DESC 
			LIMIT $inicial, $numreg";
			
	$sql_pesquisa = mysqli_query($conn, $sql)
		Or die('Erro ao realizar a pesquisa. '.mysqli_error($conn));
	
	$total_pesquisa = @mysqli_num_rows($sql_pesquisa);
	
	if($total_pesquisa == 0){
?>
				<div id="search">
					<h1 class="legenda-email falha">Não há resultado para essa pesquisa</h1>
					<p class="msg_erro"> Faça pesquisas por uma palavra chave ou expressão.</p>
				</div>
			</div>
<?php
		
		include "sidebars/sidebar.php";
		$chamada = 'page-sidebar';

		for($i = 1; $i <= 3; $i++){
			$categoria = $i;
			include "scripts/posts.php";
		}
		return;
	}else{
?>
				<h1 class="legenda-page">Pesquisa</h1>
                
				<div id="search">
					<ul class="search-lista">
<?php
		$cont = 0;
		
		while($res_pesquisa = mysqli_fetch_array($sql_pesquisa)){
			$cont++;

			$id = $res_pesquisa[0];
			$thumb = $res_pesquisa[1];
			$url_post = $res_pesquisa[2];
			$titulo = $res_pesquisa[3];
			$descricao = $res_pesquisa[4];
			$categoria_post = $res_pesquisa[5];
			$subtitulo = $res_pesquisa[6];
			$texto = $res_pesquisa[7];
			
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
                        <a href="index.php?pagina=nav/single&amp;<?php echo 'id=' . $id . '&post=' . $url_post; ?>">
                            <li class="search-linha <?php echo $margem;?> linha<?php echo $cont;?>">
                                <img src="upload/<?php echo $descricao;?>/<?php echo sprintf("%06d", $id); ?>/img_m/<?php echo $thumb;?>" alt="<?php echo $titulo; ?>" class="search-img" />
                                <h2 class="search-titulo legenda-<?php echo $descricao;?>"><?php echo $titulo; ?></h2>
<?php
			if($categoria_post <> 1){
				echo '									<p>'.$subtitulo.'</p>';
			}

?>
                            </li>
                        </a>
<?php
			if($cont == $total_pesquisa){
?>	
                    </ul>
                </div>
<?php
			}
		}
	}
?>
					<div style="clear:both;"></div>
                	<?php echo paginacao($page, $total, "index.php?pagina=nav/search&pesquisa=".$pesquisa."&pg="); ?>               
			</div>
<?php 
	include "sidebars/sidebar.php";
	$chamada = 'page-sidebar';
	
	for($i = 1; $i <= 3; $i++){
		$categoria = $i;
		include "scripts/posts.php";
	}
?>