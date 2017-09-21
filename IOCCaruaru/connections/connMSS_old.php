<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	$dbhost = "localhost";
	$db = "sisac";
	$user = "magno";
	$password = "magno10";
	
	$conninfo = array("Database" => $db, "UID" => $user, "PWD" => $password);
	$connMSS = sqlsrv_connect($dbhost, $conninfo);
	
	if(!$connMSS){
    	die(print_r( sqlsrv_errors(), true));
	}
?>