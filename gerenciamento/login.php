<?php	 
	include "../funcoes.php"; 

	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$usuario = anti_injection($_POST['usuario']);
		$senha = anti_injection(md5($_POST['senha']));
		
		include "../connections/conn.php";
		
		$sql_login = "SELECT * FROM ioc_usuarios WHERE usuario = '$usuario' and senha='$senha'";
		$query_login = mysqli_query($conn, $sql_login) or die(mysqli_error($conn));
		$qtd_usuario = mysqli_num_rows($query_login);
	
		if ($qtd_usuario==0){
			$resposta = "<div id='erroLogin'>Login ou senha incorreto! Tente novamente.</div>";
			mysqli_close($conn);
		}else{
			$id_usuario = mysqli_fetch_assoc($query_login);
			//$_SESSION['usuario'] = mysqli_fetch_assoc($query_login);
			//$id_usuario = $_SESSION['usuario']['id'];
			mysqli_query($conn, "UPDATE ioc_usuarios SET data_ultimo_login=now() WHERE id='".$id_usuario['id']."'")
				or die(mysqli_error($conn));
			mysqli_close($conn);
			echo "<script>location.href='index.php?&us=".$id_usuario['id']."'</script>";
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Login</title>
		<link href="style_manages.css" rel="stylesheet" type="text/css" />
	</head>

	<body id="body-login">
        <div id="login">
        	<form id="form1" name="form1" method="post" action="">
            	<label id="lblUsuario">login:</label>
            	<input name="usuario" type="text" id="usuario" autocomplete="off" autofocus="autofocus" />
          		<br />
          		<label id="lblSenha">senha:</label>
          		<input name="senha" type="password" id="senha" />
          		<br />
          		<input type="image" id="imageField" class="btn-entrar" src="img/33.png" />
        	</form>
        	<?=@$resposta;?>
        </div>
	</body>
</html>