<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	$hostname_conn = "localhost";
	$database_conn = "ioccaruaru";
	$username_conn = "root";
	$password_conn = "";
	$conn = new mysqli($hostname_conn, $username_conn, $password_conn, $database_conn);
	
	if (!$conn){
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . $conn->connect_errno . PHP_EOL;
		echo "Debugging error: " . $conn->connect_error . PHP_EOL;
	}
	
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET character_set_connection=utf8');
	$conn->query('SET character_set_client=utf8');
	$conn->query('SET character_set_results=utf8');
?>