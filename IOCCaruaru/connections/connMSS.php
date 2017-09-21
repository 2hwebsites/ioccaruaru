<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	$dbhost = "ioccaruaru.ddns.net";
	$db = "sisac";
	$user = "magno";
	$password = "magno10";
	
	$conn1 = mssql_connect($dbhost, $user, $password);
	mssql_select_db($conn1, $db);
	
	//$conninfo = array("Database" => $db, "UID" => $user, "PWD" => $password);
//	$connMSS = mssql_pconnect($dbhost, $conninfo);
//	
//	if(!$connMSS){
//    	die(print_r( sqlsrv_errors(), true));
//	}
?>