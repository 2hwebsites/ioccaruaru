<?php
	$str_subtitulo = ', ip.subtitulo ';

	if($categoria == 1){
		$legenda = 'Galeria';
		
		if($chamada <> 'info-sidebar'){
			$str_subtitulo = ' ';
		}
	} elseif($categoria == 2){		
		$legenda = 'Notícias';
	} elseif($categoria == 3){
		$legenda = 'Dicas de Saúde';
	}

	$where = "= '$categoria' ";
	$limite = 'LIMIT 3';
	
	if($chamada == 'page-sidebar'){
		$limite = 'LIMIT 1';
	} elseif($chamada == 'single-sidebar'){
		$where = $where."AND ip.id <> '$id_atual' AND ip.categoria_id <= 3 ";
	} elseif($chamada == 'info-sidebar'){
		$where = "<> '$categoria' AND ip.categoria_id <= '3' ";
	}
	
	include "connections/conn.php";
	
	$sql = "SELECT ip.id, ip.titulo, ip.thumb, ip.url_post, ip.categoria_id, ic.descricao".$str_subtitulo.
			"FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.categoria_id ".$where." AND ip.ativo = '1'
			ORDER BY ip.id DESC ".$limite;
	
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
			$titulo = $res_post[1];
			$thumb = $res_post[2];
			$url_post = $res_post[3];
			$categoria_post = $res_post[4];
			$descricao = $res_post[5];
			
			if($categoria_post <> 1){
				$subtitulo = $res_post[6];
			}
				
			if($chamada == 'home'){
				if($cont == 1){
					$margem = ' margin-esquerda margin-direita semMagemTop';
?>
				<div id="<?php echo $descricao; ?>">
					<h1 class="legenda legenda-<?php echo $descricao; ?>"><?php echo $legenda; ?></h1>
                    
					<ul class="informacao-lista">
<?php
				} else{
					$margem = ' margin-direita';
					
					if($cont == $total_posts){
						$margem = '';
					}
				}
?>
                        <a href="index.php?pagina=nav/<?php echo ($categoria_post == '1' ? 'galeria_' : ''); ?>single&amp;
							<?php echo 'id='.$id.'&post='.$url_post; ?>" class="link-informacao">
                            <li class="informacao-linha<?php echo $margem; ?>">
                                <img src="upload/<?php echo $descricao; ?>/<?php echo sprintf("%06d", $id); ?>/<?php echo ($categoria_post <> '1' ? 'img_p/' : ''); ?><?php echo $thumb; ?>" 
                                	alt="<?php echo $titulo; ?>" class="informacao-img" />
                                <h2 class="informacao-titulo legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h2>
<?php 
                                    if($categoria_post <> 1){
                                        echo '<p>'.$subtitulo.'</p>';
                                    }
?>
                            </li>
                        </a>
<?php
                if($cont == $total_posts){
?>
                    </ul>
                </div>
<?php
                }
            } else {
				if(($chamada <> 'page-sidebar' && $cont == 2) || ($chamada == 'page-sidebar' && $categoria == 2)){
					$borda = ' sb-bordas';
				} else{
					$borda = '';
				}
?>
                        <a href="index.php?pagina=nav/<?php echo ($categoria_post == '1' ? 'galeria_' : ''); ?>single&amp;<?php echo 'id='.$id.'&post='. $url_post; ?>" class="link-informacao">
                            <li id="sidebar-linha" class="informacao-linha<?php echo $borda; ?>">
                                <img src="upload/<?php echo $descricao; ?>/<?php echo sprintf("%06d", $id); ?>/<?php echo ($categoria_post <> '1' ? 'img_p/' : ''); ?><?php echo $thumb; ?>" 
                                	alt="<?php echo $titulo; ?>" class="informacao-img" />
                                <h2 class="informacao-titulo legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h2>
<?php 
                if($categoria_post <> 1){
                    echo '<p>'.$subtitulo.'</p>';
                }
?>
                   			</li>
                		</a>
<?php
            	if(($chamada <> 'page-sidebar' && $cont == $total_posts) || ($chamada == 'page-sidebar' && $categoria == 3)){
?>
            		</ul>
        		</div>
    		</div>
<?php
            	}
			}
		}
	}
?>