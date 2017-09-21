<div id="sidebar">
    <?php
		$categoria = 5;
		$sql = "SELECT ib.thumb, ic.descricao 
				FROM ioc_banner AS ib 
				INNER JOIN ioc_categoria AS ic ON ib.categoria_id = ic.id 
				WHERE ib.categoria_id = $categoria 
				ORDER BY ib.id DESC";
		$banner = mysqli_query($conn, $sql)
			Or die('Erro ao obter banner. '.mysqli_error($conn));
		
		if(@mysqli_num_rows == '0'){
			echo "Não há notícias cadastradas";
		} else{
			$res_banner = mysqli_fetch_array($banner);
		}
    ?>
    
    <div id="<?php echo $res_banner[1]; ?>"><a href="#"><img src="upload/<?php echo $res_banner[1]; ?>/<?php echo $res_banner[0]; ?>" alt="" /></a></div>