<?php
echo "<script>location.href='../breve.php'</script>";

session_start();
	
if(!isset($_SESSION['atendimento'])){
	header("Location:login_exame.php");
}	
	
?><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <title>Entrega de exame</title>
    <link href="style_exame.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../img/logo-circulo-IOC.fw.png" type="image/x-icon" />
    
    <script type="text/javascript" src="../js/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="../js/funcoes_aux.js"></script>
    <script type="text/javascript" src="../js/critica_exame.js"></script>﻿
</head>

<body>
	<div class="container clearfix">
    	<div class="header">
        	<div class="logo">
        		<img src="../img/logo_grande.jpg" alt="" />
            </div>
		</div>
        
        <div class="article">
            <div id="page">                
<?php
	include "../connections/conn.php";
	
	$examesSql = "SELECT id, titulo_exame, exame, dt_entrega, dt_impressao
					FROM ioc_exames WHERE atendimento = '".$_SESSION['atendimento']."' ORDER BY dt_entrega DESC, id ";
	$examesQy  = mysqli_query($conn, $examesSql) or die(mysqli_error($conn));

	mysqli_close($conn);

	if (@mysqli_num_rows($examesQy) == '0'){
?>
			<div id="msg_Exame">
				<p>Não há exames disponíveis para esse paciente ou o resultado do exame ainda não está pronto.</p>
			</div>
<?php
		session_destroy();
	}else{
?>
				<div id="entrega_exame">
                	<table id="tabela-exame" border="0" align="center" cellpadding="0" cellspacing="0" >
                    	<tr class="cabecalho-exame">
                            <td align="center" valign="middle" bgcolor="#20232E" class="tit_tabela">Exame</td>
                            <td align="center" valign="middle" bgcolor="#20232E" class="data_tabela">Data Entrega</td>
                            <td align="center" valign="middle" bgcolor="#20232E" class="data_tabela">Visualização</td>
                      	</tr>
<?php
		while($res_examesQy = mysqli_fetch_array($examesQy)){
			$id = $res_examesQy[0];
			$tituloExame = $res_examesQy[1];
			$exame = $res_examesQy[2];
			$dt_entregaArray = explode("-", $res_examesQy[3]);
			$dt_entrega = $dt_entregaArray[2]."/".$dt_entregaArray[1]."/".$dt_entregaArray[0];
			
			if(empty($res_examesQy[4])){
				$dt_impressao = $res_examesQy[4];
			} else{
				$dt_impressaoArray = explode("-", $res_examesQy[4]);
				$dt_impressao = $dt_impressaoArray[2]."/".$dt_impressaoArray[1]."/".$dt_impressaoArray[0];
			}
		
			$cor = (@$cor == "#e4e4e4")?"":"#e4e4e4";

			if($dt_entregaArray[0].$dt_entregaArray[1].$dt_entregaArray[2] <= date("Ymd")){ 
				$corTexto = "";
				$link = "<a href='examepdf.php?&amp;id=".$id."&amp;exame=".$exame."&amp;atendimento=".$_SESSION['atendimento']."' target='_blank'>".$tituloExame."</a>";
				$linkHover = "linkHover";
			}else{ 
				$corTexto = "style='color:red'";
				$link = $tituloExame;
				$linkHover = "";
			}
?>
                      	<tr bgcolor="<?php echo $cor; ?>" class="lista-exame <?php echo $linkHover; ?>">
							<td align="left" valign="middle" class="tit_exame" <?php echo $corTexto; ?>><?php echo $link; ?></td>
                            <td align="center" valign="middle" <?php echo $corTexto; ?>><?php echo $dt_entrega; ?></td>
                            <td align="center" valign="middle" <?php echo $corTexto; ?>><?php echo $dt_impressao; ?></td>
                      	</tr>
<?php	 }?>
					</table>
				</div>
<?php
	}
?>
            </div>
        </div>
	</div>
</body>
</html>
<?php
session_destroy();
?>
