<?php
session_start();

$msgErro = "";
$msgErro2 = "";

include "../funcoes.php";

if ($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST)){
		$_SESSION['atendimento'] = anti_injection($_POST['atendimento']);
		$senha = md5(anti_injection($_POST['senha']));
		
		include "../connections/conn.php";

		$sql_login = "SELECT * FROM ioc_exames WHERE atendimento = '".$_SESSION['atendimento']."' and senha='".$senha."'";
		$query_login = mysqli_query($conn, $sql_login) or die(mysqli_error($conn));
		$qtd_usuario = mysqli_num_rows($query_login);

		if ($qtd_usuario == 0){
			$msgErro = "Atendimento ou senha inválido!";
			$msgErro2 = "Caso seja a primera vez que está acessando, aguarde até a data de entrega do exame";
		} else{
			echo "<script>location.href='index.php'</script>";

		}
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <title>Entrega de exame</title>
    <link href="style_exame.css" rel="stylesheet" type="text/css" />
    
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
                <div id="login_exame">
                	<div id="msgErro">
                    	<p class="msgErro"><?php echo $msgErro; ?></p>
                    	<p class="msgErro"><?php echo $msgErro2; ?></p>
                    </div>
                    <form name="entrega_exame" method="post" action="login_exame.php" enctype="multipart/form-data" 
                    	onSubmit="return criticaExame(this, 'exame');">
                        <fieldset class="destaque">
                            <legend class="legenda-destaque">Entrega de Exame</legend>
                
                            <label for="atendimento">Atendimento</label>
                            <input type="text" id="atendimento" name="atendimento" class="txt-destaque" maxlength="6" 
                            	onKeyPress="return SomenteNumero(event)" autofocus autocomplete="off" />
                            
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" class="txt-destaque margem-left" maxlength="8" 
                                onKeyPress="return SomenteNumero(event)" />
                            
                            <div id="botaoEnviar">
                                <input type="submit" name="enviar" value="OK" class="btn-enviar" />
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
	</div>
</body>
</html>