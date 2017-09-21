<?

if(@$_GET['acao']=='excluir'){
	$excluir = mysql_query("UPDATE paginas SET ativo=0 where id='$_GET[id]'") or die(mysql_error());
	redireciona("index.php?t=conteudo_postados&secao=".$_GET['secao']."");
}
/*** inicio da paginação  ************************************************************************************/

$numreg=20; //registros por pagina

//Obtem pagina atual
$page = 1;
if (isset($_GET['p'])){
	$page =$_GET['p']; // exemplo:  $_GET['p'];
}
$inicial=($page-1)*$numreg;

// Obtem numero total de paginas para paginação
$query="SELECT  count(*) as total FROM paginas WHERE ativo=0";
$paginacao = mysql_fetch_assoc(mysql_query($query));
$regTotal=$paginacao['total'];
$total = ceil($regTotal/$numreg); // exemplo:  $db['result']['total_pages'];

/***** fim da paginação  ************************************************************************************/


$categoriasSql    = "SELECT  * FROM paginas WHERE ativo=0 ORDER BY id DESC LIMIT $inicial, $numreg";
$categoriasQy     = mysql_query($categoriasSql) or die(mysql_error());
if (mysql_num_rows($categoriasQy)>0)
{
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="50" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Id</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Sel</td>
    <td width="300" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">T&iacute;tulo</td>
    <td width="20" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">D</td>
    <td width="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">O/S</td>
    <td width="150" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Secretaria</td>
    <td width="50" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Postagem</td>
  </tr>
<?  
while($categoriasRow    = mysql_fetch_assoc($categoriasQy)){
$secretaria2 = mysql_fetch_assoc(mysql_query("select * from secretarias where id='$categoriasRow[id_secretaria]'"));

$cor=(@$cor=="#EFEEE6")?"":"#EFEEE6";
?>
  <tr  bgcolor="<?=$cor;?>">

    <td   width="50" height="25" align="center" valign="middle"><?=sprintf("%06d", $categoriasRow['id']);?></td>

    <td    width="30" align="center" valign="middle"><input name="id_conteudo" id="id_conteudo" type="radio" value="<?=$categoriasRow['id'];?>" />	</td>

    <td    width="300" align="left" valign="middle">
	<a href="<?=$urlBase.'conteudo/'.$categoriasRow['id'];?>" target="_blank">
	<?=$categoriasRow['titulo'];?>
	</a>
	</td>
    <td    width="20" align="center" valign="middle">	<input disabled="disabled" name="destaque" type="checkbox" <?=($categoriasRow['destaque']==1)?"checked='checked'":"";?> /></td>
    <td    width="30" align="center" valign="middle"><input  disabled="disabled" name="destaque_org_sec" type="checkbox" <?=($categoriasRow['destaque_org_sec']==1)?"checked='checked'":"";?> /></td>
    <td    width="150" align="center" valign="middle"><?=$secretaria2['abreviado'];?></td>

    <td   width="50" align="center" valign="middle"><?=converte_data($categoriasRow['data']);?></td>
  </tr>
<? } ?>
</table>
<?
}else{
echo "<br>Nenhuma conteudo encontrado!";
}

?>

<div style="clear:both; padding-top:30px;"><center><?=paginacao($page, $total, "index.php?t=conteudo_postados&secao=$_GET[secao]");?></center></div>

<script type="text/javascript">
$(function(){
	
	//editar conteudo
	$('#editar_conteudo').click(function(){
	id = $('input:radio[name=id_conteudo]:checked').val()
	if(id==null){
		alert('Selecione um registro para editar...');
		}else{
			location.href=('index.php?t=conteudo_editar&secao=<?=$_GET['secao'];?>&id='+id);
			}
	});


	//galeria de imagens
	$('#galeria').click(function(){
	id = $('input:radio[name=id_conteudo]:checked').val();
	if(id==null){
		alert('Selecione um registro para acrescentar a galeria...');
		}else{
			location.href=('index.php?t=galeria_novo&secao=<?=$_GET['secao'];?>&id='+id);
			}
	});


	//documentos
	$('#documentos').click(function(){
	id = $('input:radio[name=id_conteudo]:checked').val();
	if(id==null){
		alert('Selecione um registro para acrescentar documentos...');
		}else{
			location.href=('index.php?t=documentos&secao=<?=$_GET['secao'];?>&id='+id);
			}
	});


	//AUDIO
	$('#audio').click(function(){
	id = $('input:radio[name=id_conteudo]:checked').val();
	secao = <?=$_GET['secao'];?>;
	if(id==null){
		alert('Selecione um registro para acrescentar audio...');
		}else{
			if(secao==14){
			location.href=('index.php?t=audio&secao='+secao+'&id='+id);
			}
			}
	});


	//excluir arquivos
	$('#excluir').click(function(){
	id = $('input:radio[name=id_conteudo]:checked').val();
	if(id==null){
		alert('Selecione um registro ...');
		}else{
			resp=confirm('Confirma a exlusão do registro N.'+id);
			if (resp){
			location.href=('index.php?t=conteudo_postados&acao=excluir&secao=<?=$_GET['secao'];?>&id='+id);	
			}			
			}
	});


});
</script>