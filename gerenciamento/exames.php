<?php
	$cat = $_GET['cat'];
	
	if(@$_GET['acao'] == '3'){
		include "../connections/conn.php";
		mysqli_query($conn, "UPDATE ioc_exames SET ativo='0' where id='$_GET[id]'") or die(mysqli_error($conn));
		mysqli_close($conn);
		redireciona("index.php?p=exames&cat=8&us=".$usuario['id']);
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
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total FROM ioc_exames WHERE ativo = '1'"));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg);

	/***** fim da paginação  ************************************************************************************/
	
	$examesSql = "SELECT id, nome, titulo_exame
						FROM ioc_exames
						WHERE ativo = '1'
						ORDER BY id DESC LIMIT $inicial, $numreg";
	$examesQy  = mysqli_query($conn, $examesSql) or die(mysqli_error($conn));
	
	mysqli_close($conn);

	if (@mysqli_num_rows($examesQy) == '0'){
		echo "<br>Nenhum exame encontrado!";
	}else{
?>
<table id="lista-conteudo" width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="cabecalho-conteudo">
    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Sel</td>
    <td width="200" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Nome</td>
    <td width="200" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Exame</td>
  </tr>
<?php
		while($res_examesQy = mysqli_fetch_array($examesQy)){
			$id = $res_examesQy[0];
			$nome = $res_examesQy[1];
			$exame = $res_examesQy[2];
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-conteudo">
    <td width="50" height="25" align="center" valign="middle"><?php echo sprintf("%06d", $id); ?></td>
    <td width="30" align="center" valign="middle"><input name="id_conteudo" id="id_conteudo" type="radio" value="<?php echo $id; ?>" /></td>
    <td width="200" align="left" valign="middle">
    	<a href="<?php echo "index.php?p=exame_editar&id=".$id."&us=".$usuario['id']; ?>"><?php echo $nome; ?></a>
	</td>
    <td width="200" align="left" valign="middle"><?php echo $exame; ?></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
?>

<div style="clear:both; padding-top:30px;">
	<center><?php echo paginacao($page, $total, "index.php?p=exames&us=".$usuario['id']."&pg="); ?></center>
</div>