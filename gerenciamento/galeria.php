<?php
$id = $_GET['id'];
include "../connections/conn.php";

$galeriaSql = "SELECT id, thumb, legenda FROM ioc_galeria WHERE posts_id = '".$id."'";
$galeriaQy  = mysqli_query($conn, $galeriaSql) or die(mysqli_error($conn));
$Qtde_img = mysqli_num_rows($galeriaQy);

mysqli_close($conn);

if ($Qtde_img == '0'){
	echo "<br>Nenhuma imagem encontrada!";
}else{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = "../data2/images/";
		$pathThumbnail = "../data2/tooltips/";
		$pathTmp = "../upload/tmp/";
		$pathImgCapa = "../upload/galeria/".sprintf("%06d", $id)."/";
			
		for($i = 0; $i < $Qtde_img; $i++){
			$legenda = $res_galeriaQy[2];
			$alteracao['id'][$i] = "";
			$alterarImg = !empty($_FILES['alterar'.$i]['name']);
			
			if(isset($_POST['excluir'.$i])){
				excluirImagem($_POST['id'.$i]);
				if(file_exists($path.$_POST['thumb'.$i])){
					unlink($path.$_POST['thumb'.$i]);
				}
				if(file_exists($pathThumbnail.$_POST['thumb'.$i])){
					unlink($pathThumbnail.$_POST['thumb'.$i]);
				}
			} else{
				$alteracao['imagem'][$i] = ($alterarImg ? date("ymdHis").$_FILES['alterar'.$i]['name'] : "");
				$alteracao['thumbtmp'][$i] = ($alterarImg ? $_FILES['alterar'.$i]['tmp_name'] : "");
				$alteracao['legenda'][$i] = (trim($legenda) <> trim($_POST['legenda'.$i]) ? $_POST['legenda'.$i] : "");

				if($alterarImg || trim($legenda) <> trim($_POST['legenda'.$i])){
					$alteracao['id'][$i] = $_POST['id'.$i];
				}
				
				if(!empty($alteracao['id'][$i])){
					alterarGaleria($id, $alteracao['imagem'][$i], $alteracao['legenda'][$i], $alteracao['id'][$i], "");
					
					if($alterarImg){
						if(file_exists($path.$_POST['thumb'.$i])){
							unlink($path.$_POST['thumb'.$i]);
						}
						if(file_exists($pathThumbnail.$_POST['thumb'.$i])){
							unlink($pathThumbnail.$_POST['thumb'.$i]);
						}
						move_uploaded_file($alteracao['thumbtmp'][$i], $pathTmp.$alteracao['imagem'][$i]);
						
						if($i == 0){
							$campos = array(0 => "thumb");
							$valores = array(0 => "'".$alteracao['imagem'][$i]."'");
							AlterarDados($campos, $valores, "ioc_posts", $id);
							if(file_exists($pathImgCapa.$_POST['thumb'.$i])){
								unlink($pathImgCapa.$_POST['thumb'.$i]);
							}
							AjustaImagem($pathTmp, "", $pathImgCapa, $alteracao['imagem'][$i], 1326, 900, false, 95, true, false);
						}
						AjustaImagem($pathTmp, $path, $pathThumbnail, $alteracao['imagem'][$i], 800, 450, true, 48, false, true);
					}
				}
			}
		}
		
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php?p=galerias&cat=1&us=".$usuario['id']."'>";
	}
?>
<form onSubmit="return critica(this);" action ="" method="post" enctype="multipart/form-data" name="galeria_editar" id="galeria_editar">
    	<fieldset>
        	<legend>Editar Galeria</legend>
<table id="lista-galeria" width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="cabecalho-conteudo">
    <td width="50" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Excluir</td>
    <td width="80" height="30" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Imagem</td>
    <td width="80" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Alterar</td>
    <td width="450" align="center" valign="middle" bgcolor="#20232E" class="tit_formulario">Legenda</td>
  </tr>
<?php
		$cont = 0;
		$imagens = array();
		$id_imagem = array();
		while($res_galeriaQy = mysqli_fetch_array($galeriaQy)){
			$id_thumb = $res_galeriaQy[0];
			$thumb = $res_galeriaQy[1];
			$legenda = $res_galeriaQy[2];
	
			$cor = (@$cor == "#EFEEE6")?"":"#EFEEE6";
?>
  <tr bgcolor="<?php echo $cor; ?>" class="lista-imagens">
  	<td width="50" align="center" valign="middle">
<?php if($cont > 0){ ?>
    	<input type="checkbox" name="excluir<?php echo $cont; ?>" id="excluir<?php echo $cont; ?>" />
<?php } ?>
    </td>
    <td width="80" height="25" align="center" valign="middle">
    	<img src="<?php echo "../data2/tooltips/".$thumb; ?>" alt="" />
    </td>
    <td width="80" align="left" valign="middle">
    	<input type="file" id="alterar<?php echo $cont; ?>" name="alterar<?php echo $cont; ?>" value="Alterar" />
    	<!--<input type="button" id="alterar" name="alterar" value="Alterar" />-->
	</td>
    <td width="450" align="left" valign="middle">
    	<input type="text" name="legenda<?php echo $cont; ?>" id="legenda<?php echo $cont; ?>" value="<?php echo $legenda; ?>" class="full" maxlength="80" />
    </td>
  </tr>
<?php
			$imagens[$cont] = $thumb;
			$id_imagem[$cont] = $id_thumb;
			$cont++;
		}
?>
</table>
<?php
		for($i = 0; $i < $cont; $i++){
?>
			<input type="hidden" id="thumb<?php echo $i; ?>" name="thumb<?php echo $i; ?>" value="<?php echo $imagens[$i]; ?>" />
            <input type="hidden" id="id<?php echo $i; ?>" name="id<?php echo $i; ?>" value="<?php echo $id_imagem[$i]; ?>" />
<?php
		}
?>
			<input type="hidden" id="contador" name="contador" value="<?php echo ($cont - 1); ?>" />
			<input name="cadastrar" type="submit" id="cadastrar" value="Editar" class="cadastrar_btn" />
        </fieldset>
    </form>
<?php
	}
?>