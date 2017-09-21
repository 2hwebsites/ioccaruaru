<?php
	$cat = $_GET['cat'];
	
	if(@$_GET['acao'] == '3'){
		include "../connections/conn.php";
		mysqli_query($conn, "UPDATE ioc_posts SET ativo = '0' where id='$_GET[id]'") or die(mysqli_error($conn));
		mysqli_close($conn);
		redireciona("index.php?p=banners&cat=5&us=".$usuario['id']);
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
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total FROM ioc_posts WHERE ativo = '1' AND categoria_id = '5'"));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg);

	/***** fim da paginação  ************************************************************************************/
	
	$noticiasSql = "SELECT ip.id, ip.titulo, iu.nome_resumido AS nome
						FROM ioc_posts AS ip
						INNER JOIN ioc_usuarios AS iu ON ip.usuario_id = iu.id
						WHERE ip.categoria_id = '".$cat."' AND ip.ativo = '1'
						ORDER BY ip.id DESC LIMIT $inicial, $numreg";
	$noticiasQy  = mysqli_query($conn, $noticiasSql) or die(mysqli_error($conn));
	
	mysqli_close($conn);

	if (@mysqli_num_rows($noticiasQy) == '0'){
		echo "<br>Nenhum banner encontrado!";
	}else{
?>
<table id="lista-conteudo" width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="cabecalho-conteudo">
    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Sel</td>
    <td width="300" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Título</td>
    <td width="150" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Usuário</td>
  </tr>
<?php
		while($res_noticiasQy = mysqli_fetch_array($noticiasQy)){
			$id = $res_noticiasQy[0];
			$titulo = $res_noticiasQy[1];
			$nome = $res_noticiasQy[2];
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-conteudo">
    <td width="50" height="25" align="center" valign="middle"><?php echo sprintf("%06d", $id); ?></td>
    <td width="30" align="center" valign="middle"><input name="id_conteudo" id="id_conteudo" type="radio" value="<?php echo $id; ?>" /></td>
    <td width="300" align="left" valign="middle">
    	<a href="<?php echo "index.php?p=banner_editar&id=".$id."&us=".$usuario['id']; ?>"><?php echo $titulo; ?></a>
	</td>
    <td width="150" align="center" valign="middle"><?php echo $nome; ?></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
?>

<div style="clear:both; padding-top:30px;">
	<center><?php echo paginacao($page, $total, "index.php?p=banners&cat=5&us=".$usuario['id']."&pg="); ?></center>
</div>