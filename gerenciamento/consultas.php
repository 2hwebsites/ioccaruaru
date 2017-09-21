<?php
	$cat = $_GET['cat'];
		
	if(@$_GET['acao'] == '3'){
		include "../connections/conn.php";
		$excluir = mysqli_query($conn, "UPDATE ioc_datamarcacao SET ativo = '0' where id='$_GET[id]'") or die(mysqli_error($conn));
		mysqli_close($conn);
		redireciona("index.php?p=consultas&cat=9&us=".$usuario['id']);
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
	$query = "SELECT count(*) as total FROM ioc_datamarcacao WHERE categoria_id =".$cat." and ativo = '1'";
	$paginacao = mysqli_fetch_assoc(mysqli_query($conn, $query));
	$regTotal= $paginacao['total'];
	$total = ceil($regTotal/$numreg); // exemplo:  $db['result']['total_pages'];

	/***** fim da paginação  ************************************************************************************/	
	$categoriasSql = "SELECT id.id, id.datamarcacao, iu.nome_resumido, id.codmedico
						FROM ioc_datamarcacao AS id
						INNER JOIN ioc_usuarios AS iu ON id.usuario_id = iu.id
						WHERE id.categoria_id = '$cat' AND id.ativo = '1' 
						ORDER BY id.id DESC LIMIT $inicial, $numreg";
	$categoriasQy  = mysqli_query($conn, $categoriasSql) or die(mysqli_error($conn));
	
	mysqli_close($conn);

	if (@mysqli_num_rows($categoriasQy) == '0'){
		echo "<br>Nenhuma data de marcação encontrada!";
	}else{
?>
<table id="lista-conteudo" width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="cabecalho-conteudo">
    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Sel</td>
    <td width="300" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Médico(a)</td>
    <td width="150" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Usuário</td>
    <td width="50" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Data</td>
  </tr>
<?php
		while($res_categoriasQy = mysqli_fetch_array($categoriasQy)){
			$id = $res_categoriasQy[0];
			$data = $res_categoriasQy[1];
			$usuarioCadastrou = $res_categoriasQy[2];
			$codMedico = $res_categoriasQy[3];
			
			if($codMedico == '002'){
				$nome = "Dra. Nadja Caldas - Matriz";
			} else{
				$nome = "Dra. Nadja Caldas - Difusora";
			}
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-conteudo">
    <td width="50" height="25" align="center" valign="middle"><?php echo sprintf("%06d", $id); ?></td>
    <td width="30" align="center" valign="middle"><input name="id_conteudo" id="id_conteudo" type="radio" value="<?php echo $id; ?>" /></td>
    <td width="300" align="left" valign="middle">
    	<a href="<?php echo 'index.php?p=consulta_editar&acao=2&cat='.$cat.'&id='.$id."&us=".$usuario['id']; ?>"><?php echo $nome; ?></a>
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
	<center><?php echo paginacao($page, $total, "index.php?pagina=consultas&cat=$cat&us=".$usuario['id']."&pg="); ?></center>
</div>