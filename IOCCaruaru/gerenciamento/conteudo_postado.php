<?php
	$cat = $_GET['cat'];
		
	if(@$_GET['acao'] == '3'){
		include "../connections/conn.php";
		$excluir = mysqli_query($conn, "UPDATE ioc_posts SET ativo=0 where id='$_GET[id]'") or die(mysqli_error($conn));
		mysqli_close($conn);
		redireciona("index.php?pagina=conteudo_postados&cat=".$cat."");
	}
	/*** inicio da paginação  ************************************************************************************/
	
	$numreg=40; //registros por pagina
	
	//Obtem pagina atual
	$page = 1;
	
	if (isset($_GET['pg'])){
		$page = $_GET['pg'];
	}
	
	$inicial = ($page - 1) * $numreg;

	include "../connections/conn.php";
	
	// Obtem numero total de paginas para paginação
	$query = "SELECT count(*) as total FROM ioc_posts WHERE categoria_id =".$cat." and ativo=1";
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, $query));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg); // exemplo:  $db['result']['total_pages'];

	/***** fim da paginação  ************************************************************************************/
	
	$categoriasSql = "SELECT ip.id, ip.titulo, ip.data, iu.nome_resumido 
						FROM ioc_posts ip 
						INNER JOIN ioc_usuarios AS iu ON ip.usuario_id = iu.id
						WHERE ip.categoria_id = '$cat' AND ip.ativo = '1' 
						ORDER BY ip.id DESC LIMIT $inicial, $numreg";
	$categoriasQy  = mysqli_query($conn, $categoriasSql) or die(mysqli_error($conn));
	
	mysqli_close($conn);

	if (@mysqli_num_rows($categoriasQy) == '0'){
		echo "<br>Nenhum conteúdo encontrado!";
	}else{
?>
<table id="lista-conteudo" width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="cabecalho-conteudo">
    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Sel</td>
    <td width="300" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Título</td>
    <td width="150" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Usuário</td>
    <td width="50" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Postagem</td>
  </tr>
<?php
		while($res_categoriasQy = mysqli_fetch_array($categoriasQy)){
			$id = $res_categoriasQy[0];
			$titulo = $res_categoriasQy[1];
			$data = $res_categoriasQy[2];
			$usuarioCadastrou = $res_categoriasQy[3];
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-conteudo">
    <td width="50" height="25" align="center" valign="middle"><?php echo sprintf("%06d", $id); ?></td>
    <td width="30" align="center" valign="middle"><input name="id_conteudo" id="id_conteudo" type="radio" value="<?php echo $id; ?>" /></td>
    <td width="300" align="left" valign="middle">
    	<a href="<?php echo 'index.php?pagina=conteudo&acao=2&cat='.$cat.'&id='.$id; ?>"><?php echo $titulo; ?></a>
	</td>
    <td width="150" align="center" valign="middle"><?php echo $usuarioCadastrou; ?></td>
    <td width="50" align="center" valign="middle"><?php echo date('d/m/Y', strtotime($data)); ?></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
?>

<div style="clear:both; padding-top:30px;">
	<center><?php echo paginacao($page, $total, "index.php?pagina=conteudo_postados&cat=$cat"); ?></center>
</div>