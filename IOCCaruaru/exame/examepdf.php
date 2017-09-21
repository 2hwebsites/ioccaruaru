<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		
		include "../connections/conn.php";
		
		mysqli_query($conn, "UPDATE ioc_exames SET dt_impressao = '".date("Y-m-d")."' WHERE id = '$id'")
										Or die('Erro ao salvar data de impressão. '.mysqli_error($conn));
		
		mysqli_close($conn);
	}
	
	if(isset($_GET['exame'])){
		$exame = $_GET['exame'];
		
		if(isset($_GET['atendimento'])){
			$atendimento = $_GET['atendimento'];
			
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../upload/exames/".$atendimento."/".$exame."'>";
		}
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
    <title>Redirecionando...</title>
</head>

<body>
</body>
</html>