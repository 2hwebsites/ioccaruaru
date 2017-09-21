<?php
	if($categoria == 1){
		$legenda = 'Galeria';
		$str_subtitulo = '';
	} else if($categoria == 2){
		$str_subtitulo = ', ip.subtitulo';
		$legenda = 'Notícias';
	} else if($categoria == 3){
		$str_subtitulo = ', ip.subtitulo';
		$legenda = 'Dicas de Saúde';
	}

	$sql = "SELECT ip.id, ip.thumb, ip.url_post, ip.titulo, ic.descricao".$str_subtitulo.
			" FROM ioc_posts AS ip 
			INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
			WHERE ip.categoria_id = '$categoria'
			ORDER BY ip.id DESC 
			LIMIT 3";

	$info = mysqli_query($conn, $sql)
		Or die('Erro ao obter informações do home. '.mysqli_error($conn));
	
	if(@mysqli_num_rows($info) == '0'){
		echo "Não há informações cadastradas.";
	}else{
		$cont = 0;
		
		while($res_info = mysqli_fetch_array($info)){
			$cont++;
			$margem = ' margin-direita';
			
			$id = $res_info[0];
			$thumb = $res_info[1];
			$url_post = $res_info[2];
			$titulo = $res_info[3];
			$descricao = $res_info[4];
			
			if($categoria <> 1){
				$subtitulo = $res_info[5];
			}			
				
			if($cont == 1){
?>
            <div id="<?php echo $descricao; ?>">
                <h1 class="legenda legenda-<?php echo $descricao; ?>"><?php echo $legenda; ?></h1>
                
                <ul class="informacao-lista">
<?php
			} elseif($cont == 3){
				$margem = '';
			}
?>
                    <a href="index.php?pagina=nav/single&amp;topico=<?php echo 'id=' . $id . ';post=' . $url_post; ?>" class="link-informacao">
                        <li class="informacao-linha<?php echo $margem; ?>">
                            <img src="upload/<?php echo $descricao;?>/<?php echo $thumb;?>" alt="<?php echo $titulo;?>" class="informacao-img" />
                            <h2 class="informacao-titulo legenda-<?php echo $descricao; ?>"><?php echo $titulo; ?></h2>
                            <?php 
                                if($categoria <> 1){
                                    echo '<p>'.$subtitulo.'</p>';
                                }
                            ?>
                        </li>
                    </a>
		<?php
			if($cont == 3){
        ?>
                </ul>
            </div>
		<?php
            }
		}
	}
?>