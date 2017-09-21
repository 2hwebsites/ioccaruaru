<?php
	foreach ($_REQUEST as $___opt => $___val){
		$$___opt = $___val;
	}

	if($pagina == "nav/single"){
		$id_single = $_GET['id'];
		$url_title = $_GET['post'];
		
		$url_face = "http://www.ioccaruaru.com.br/doubleeitch/index.php?pagina=nav/single&id=".$id_single."&post=".$url_title;
		
		include "connections/conn.php";
		
		$sql = "SELECT ip.titulo, ip.data, ip.subtitulo, ip.thumb, ip.nao_exibir_thumb, ip.thumb_banner, ip.video, ip.texto,  
				ip.autor, ip.categoria_id, ic.descricao
				FROM ioc_posts AS ip 
				INNER JOIN ioc_categoria AS ic ON ip.categoria_id = ic.id 
				WHERE ip.id = '$id_single' AND ip.url_post = '$url_title' AND ip.ativo = '1'";
	
		$single_page = mysqli_query($conn, $sql)
			Or die('Erro ao obter post.'.mysqli_error($conn));
		
		mysqli_close($conn);
			
		if(@mysqli_num_rows($single_page) == '0'){
			echo "Este post não está cadastrado ou foi excluído.";
		}else{
			$res_single_page = mysqli_fetch_array($single_page);
			
			$titulo = $res_single_page[0];
			$data = $res_single_page[1];
			$subtitulo = $res_single_page[2];
			$thumb = $res_single_page[3];
			$naoExibirThumb = $res_single_page[4];
			$thumb_banner = $res_single_page[5];
			$video = $res_single_page[6];
			$texto = $res_single_page[7];
			$autor = $res_single_page[8];
			$post_categoria = $res_single_page[9];
			$descricao = $res_single_page[10];
		}
	}
	
	include "header.php";
	
	if(empty($pagina)){
		include("nav/home.php");
	}
	elseif(substr($pagina, 0, 4)=='http' or substr($pagina, 0, 1)=="/" or substr($pagina, 0, 1)=="."){
		echo '<br /><font face=arial size=11px><br /><b>A página não existe.</b><br />Por favor selecione uma página a partir do menu principal.';
	}
	else{
		include("$pagina.php");
	}
?>

<?php include "footer.php"; ?>
