			<div id="page">

<?php
	$url = $_GET['url'];
	
	include "connections/conn.php";
	
	$sql = "SELECT ip.id, ip.url_page, ip.content
			FROM ioc_page AS ip
			WHERE ip.url_page = '$url'";
	$pagina = mysqli_query($conn, $sql)
			Or die('Erro ao obter a página. '.mysqli_error($conn));
			
	mysqli_close($conn);
			
			
	if(@mysqli_num_rows($pagina) == '0'){
		echo "Não há página para essa URL.";
	}else{
		while($res_pagina = mysqli_fetch_array($pagina)){
			$id = $res_pagina[0];
			$nome_url = $res_pagina[1];
			$content = $res_pagina[2];
				
?>
				<h1 class="legenda-page"><?php echo ucfirst($nome_url); ?></h1>
				<?php echo $content; ?>
<?php
		}
	}
?>

			</div>

<?php 
	include "sidebars/sidebar.php";
	$chamada = 'page-sidebar';
	
	for($i = 1; $i <= 3; $i++){
		$categoria = $i;
		include "scripts/posts.php";
	}
?>