<?php
	$cat = $_GET['cat'];
	
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
	if ($cat >= 1 && $cat <= 6){
		$query = "SELECT count(*) as total FROM ioc_posts WHERE ativo = 0 AND categoria_id = '".$cat."'";
	} elseif($cat == 7){
		$query = "SELECT count(*) as total FROM ioc_usuarios WHERE ativo = 0";
	} elseif($cat == 8){
		$query = "SELECT count(*) as total FROM ioc_exames WHERE ativo = 0";
	} elseif($cat == 9){
		$query = "SELECT count(*) as total FROM ioc_datamarcacao WHERE ativo = 0";
	}
	
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, $query));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg); // exemplo:  $db['result']['total_pages'];

	/***** fim da paginação  ************************************************************************************/
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$id = $_POST['enviar_id'];
		
		if ($cat >= 1 && $cat <= 6){
			$reativar = "UPDATE ioc_posts SET ativo = '1' WHERE id = '".$id."'";
		} elseif($cat == 7){
			$reativar = "UPDATE ioc_usuarios SET ativo = 1 WHERE id = '".$id."'";
		} elseif($cat == 8){
			$reativar = "UPDATE ioc_exames SET ativo = '1' WHERE id = '".$id."'";
		} elseif($cat == 9){
			$reativar = "UPDATE ioc_datamarcacao SET ativo = '1' WHERE id = '".$id."'";
		}
		
		mysqli_query($conn, $reativar) or die(mysqli_error($conn));
	}
	
	// Categoria 1 ao 6
	if ($cat >= 1 && $cat <= 6){
		$excluidosSql = "SELECT ip.id, ip.titulo, iu.usuario FROM ioc_posts AS ip INNER JOIN ioc_usuarios AS iu ON iu.id = ip.usuario_id WHERE ip.ativo = '0' AND ip.categoria_id = '".$cat."'
							ORDER BY ip.id DESC LIMIT $inicial, $numreg";
		$titulo = "Título";
		$titulo2 = "Usuário";
	} elseif($cat == 7){
		$excluidosSql = "SELECT id, nome_completo, usuario
							FROM ioc_usuarios
							WHERE ativo = 0
							ORDER BY id DESC LIMIT $inicial, $numreg";
		$titulo = "Nome";
		$titulo2 = "Usuário";
	} elseif($cat == 8){
		$excluidosSql = "SELECT id, nome, titulo_exame
							FROM ioc_exames
							WHERE ativo = '0'
							ORDER BY id DESC LIMIT $inicial, $numreg";
		$titulo = "Nome";
		$titulo2 = "Título do Exame";
	} elseif($cat == 9){
		$excluidosSql = "SELECT id, codMedico, datamarcacao
							FROM ioc_datamarcacao
							WHERE ativo = '0'
							ORDER BY id DESC LIMIT $inicial, $numreg";
		$titulo = "Médico(a)";
		$titulo2 = "Data";
	}
	
	$excluidosQy  = mysqli_query($conn, $excluidosSql) or die(mysqli_error($conn));
	
	mysqli_close($conn);

	if (@mysqli_num_rows($excluidosQy) == '0'){
		echo "<br>Nenhum registro encontrado!";
	}else{
?>
<table id="lista-conteudo" width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="cabecalho-conteudo">
    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="300" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario"><?php echo $titulo; ?></td>
    <td width="125" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario"><?php echo $titulo2; ?></td>
    <td width="125" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Reativar</td>
  </tr>
<?php
		while($res_excluidosQy = mysqli_fetch_array($excluidosQy)){
			$id = $res_excluidosQy[0];
			$nome = $res_excluidosQy[1];
			$campo2 = $res_excluidosQy[2];
			
			if($cat == 9){
				if($nome == '002'){
					$nome = "Dra. Nadja Caldas - Matriz";
				} else{
					$nome = "Dra. Nadja Caldas - Difusora";
				}
				
				$campo2 = date('d/m/Y', strtotime($campo2));
			}
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-conteudo">
    <td width="50" height="25" align="center" valign="middle"><?php echo sprintf("%06d", $id); ?></td>
    <td width="300" align="left" valign="middle">
    	<a href="<?php echo "index.php?p=usuario_editar&id=".$id; ?>"><?php echo $nome; ?></a>
	</td>
    <td width="125" height="25" align="center" valign="middle"><?php echo $campo2; ?></td>
    <td width="125" align="center" valign="middle"><form action ="" method="post" enctype="multipart/form-data" class="reativar_form"><input type="hidden" name="enviar_id" value="<?php echo $id; ?>" /><input type="submit" id="reativar" value="Reativar" class="reativar_btn" /></form></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
?>

<div style="clear:both; padding-top:30px;">
	<center><?php echo paginacao($page, $total, "index.php?p=usuarios"); ?></center>
</div>