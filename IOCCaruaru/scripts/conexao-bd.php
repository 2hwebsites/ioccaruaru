<?php
	header('Content-Type: text/html; charset=utf-8');
	$servidor = "127.0.0.1";
	$usuario = "root";
	$senha = "";
	$bd = "ioccaruaru";
	$conn = new mysqli($servidor, $usuario, $senha);
	
	if($conn->connect_error){
		trigger_error("ERRO NA CONEXÃO: "  . $conn->connect_error, E_USER_ERROR);
	}

	mysqli_select_db($conn, $bd);
	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
?>