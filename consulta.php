<?php
echo "<script>location.href='breve.php'</script>";

	session_start();
	
	if(!isset($_SESSION["usuario"])){
		$_SESSION["usuario"] = md5(date("dmYHis"));
		$_SESSION["ultimoAcesso"]= date("Y-n-j H:i:s");
		$_SESSION['cont'] = 0;
	} else{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$request = md5(implode($_POST));
				
			if(!(isset($_SESSION['last_request']) && $_SESSION['last_request'] == $request)){
				$_SESSION['last_request']  = $request;
			} else{
				include "connections/conn.php";
				$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
				mysqli_query($conn, $query) Or die(mysqli_error($conn));
				mysqli_close($conn);

				session_destroy();
				header("Location:consulta.php");
			}
			
			if((isset($_POST['btnVoltar']) && $_POST['btnVoltar'] == 'Voltar') && !isset($_POST['btnOutroMedico'])){
				include "connections/conn.php";
				$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
				mysqli_query($conn, $query) Or die(mysqli_error($conn));
				mysqli_close($conn);
	
				unset($_SESSION['mesAnoBase']);
			}
			
			if(isset($_SESSION['cont']) && $_SESSION['cont'] == 1){
				var_dump("passou aqui");
				include "connections/conn.php";
				$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
				mysqli_query($conn, $query) Or die(mysqli_error($conn));
				mysqli_close($conn);
		
				session_unset();
				session_destroy();
				$h1 = "Sua Sessão Expirou";
				$p1 = "Não é permitido repetir o processo de confirmação da marcação.";
				include "mensagemerro.php";
				exit;
			} elseif(isset($_POST['btnConfirmar'])){
				$_SESSION['cont'] = 1;
			}
		} else{
			include "connections/conn.php";
			$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
			mysqli_query($conn, $query) Or die(mysqli_error($conn));
			mysqli_close($conn);

			session_destroy();
			session_start();
			$_SESSION["usuario"] = md5(date("dmYHis"));
			$_SESSION["ultimoAcesso"]= date("Y-n-j H:i:s");
		}
		
		$tempo_transcorrido = (strtotime(date("Y-n-j H:i:s"))-strtotime($_SESSION["ultimoAcesso"])); 

		if($tempo_transcorrido >= 300) {
			include "connections/conn.php";
			$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
			mysqli_query($conn, $query) Or die(mysqli_error($conn));
			mysqli_close($conn);
			
			$_SESSION["ultimoAcesso"]= date("Y-n-j H:i:s");
			
			session_destroy();
			$h1 = "Sua Sessão Expirou";
			$p1 = "Não é permitido repetir o processo de confirmação da marcação.";
			include "Location:mensagemerro.php";
			exit;
		}else { 
			$_SESSION["ultimoAcesso"] = date("Y-n-j H:i:s"); 
		}
		
		if(isset($_POST['btnOutroMedico']) && $_POST['btnOutroMedico'] == 'OutroMedico'){
			$outroMedico = "autofocus";
		}
	}

	include "consulta_funcoes.php";
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <title>Marca&ccedil;&atilde;o de Consulta</title>
    <link href="style_consulta.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="js/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="js/funcoes_aux.js"></script>
    <script type="text/javascript" src="js/critica_usuario_consulta.js"></script>
    
    <script type="text/javascript">
		function TamanhoDivTabelas(){
			var width = 0;
			var height = 0;
			var cont = 0;
			
			if(document.getElementById("tblManha") != null){
				width = $("#tblManha").width();
				height = $("#tblManha").height();
				cont += 1;
			}
			
			if(document.getElementById("tblTarde") != null){
				width += $("#tblTarde").width();
				cont += 1;
				
				if(height == 0){
					height = $("#tblTarde").height();
				} else{
					if(height < $("#tblTarde").height()){
						height = $("#tblTarde").height();
					}
				}
			}
			
			if(document.getElementById("tblNoite") != null){
				width += $("#tblNoite").width();
				cont += 1;
				
				if(height == 0){
					height = $("#tblNoite").height();
				} else{
					if(height < $("#tblNoite").height()){
						height = $("#tblNoite").height();
					}
				}
			}
			
			width += 15 * (cont - 1) + 4;
			
			$("#tabelas").css({ "width": + width + "px" });
			$("#tabelas").css({ "height": + height + "px" });
		}
	</script>
</head>

<body onLoad="TamanhoDivTabelas()">
	<div class="container clearfix">
    	<div class="header">
        	<div class="logo">
        		<img src="img/logo_grande.jpg" alt="" />
            </div>
		</div>
        
        <div class="article">
<?php 
	include "sidebars/sidebar_consulta.php"; 
?>
			
            <div id="page">
<?php
	if($_SERVER['REQUEST_METHOD'] <> "POST"){
		$_SESSION['dataMarcacao'] = "";
		
		include "consulta_usuario.php";
	} else{
		if(isset($_POST['btnVoltar']) && $_POST['btnVoltar'] == 'Voltar'){
			$_SESSION['dataMarcacao'] = "";
			
			include "consulta_usuario.php";
		} elseif(!(isset($_POST['btnMarcar']) || isset($_POST['btnConfirmar']))){
			if(isset($_POST['txhChamada'])){
				if($_POST['txhChamada'] == "MSSQL"){
					
					$_SESSION['nome'] = $_POST['nome'];
					$_SESSION['dtNasc'] = $_POST['dtNasc'];
					$_SESSION['telefone'] = $_POST['telefone'];
					$_SESSION['celular'] = $_POST['celular'];
					$_SESSION['convenio'] = $_POST['convenio'];
					$_SESSION['convenioDesc'] = $_POST['convenioDesc'];
					$_SESSION['nomeMedico'] = $_POST['nomeMedico'];
					$_SESSION['codMedico'] = $_POST['medico'];
		
					if(!obterAgendaMSSQL()){
						include "connections/conn.php";
						$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
						mysqli_query($conn, $query) Or die(mysqli_error($conn));
						mysqli_close($conn);
		
						session_destroy();
						
						echo "</div>";
						include "footer_sistemas.php";
						exit;
					}
				} 
				
				$modificadorMes = ($_POST['txhChamada'] == "MSSQL" ? 0 : $_POST['txhModificadorMes']);
				$chamada = ($_POST['txhChamada'] == "Horarios" ? "Horarios" : "");
				
				if(isset($_POST['btnDia']) && isset($_SESSION['mesAnoBase']) && $_POST['txhChamada'] == "Horarios"){
					$_SESSION['dataMarcacao'] = $_POST['btnDia']."/".$_SESSION['mesAnoBase'];
				}
				
				if(!obterAgendaMySQL($modificadorMes, $chamada)){
					include "connections/conn.php";
					$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
					mysqli_query($conn, $query) Or die(mysqli_error($conn));
					mysqli_close($conn);
	
					session_destroy();
					
					echo "</div>";
					include "footer_sistemas.php";
					exit;
				}
				
				if($_POST['txhChamada'] == "Horarios"){
					if(!obterHorarios()){
						include "connections/conn.php";
						$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
						mysqli_query($conn, $query) Or die(mysqli_error($conn));
						mysqli_close($conn);
	
						session_destroy();
						
						echo "</div>";
						include "footer_sistemas.php";
						exit;
					}
				}
			}
		} else{
			$_SESSION['confirmar'] = (!isset($_POST['btnConfirmar']) ? "S" : "N");
			
			if(isset($_POST['btnMarcar'])){
				$_SESSION['hora'] = $_POST['hora'];
				$_SESSION['turno'] = $_POST['turno'];
			} elseif(isset($_POST['btnConfirmar'])){
				if(!marcarConsulta()){
					include "connections/conn.php";
					$query = "DELETE FROM ioc_horarios WHERE usuario_id = '".$_SESSION['usuario']."'";
					mysqli_query($conn, $query) Or die(mysqli_error($conn));
					mysqli_close($conn);

					session_destroy();
					
					echo "</div>";
					include "footer_sistemas.php";
					exit;
				}
			}
			
			include "consulta_confirmacao.php";
		}
	}
?>
			</div>
		</div>

<?php include "footer_sistemas.php"; ?>