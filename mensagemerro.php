<?php
	if(!isset($h1)){
		header("Location:consulta.php");
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
    <title>Sessão Expirada</title>
    <link href="style_msgErro.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="container clearfix">
    	<div class="header">
        	<div class="logo">
        		<img src="img/logo_grande.jpg" alt="" />
            </div>
		</div>
        
        <div class="article">
			<div id="page">
            	<h1><?php echo $h1; ?></h1>
                <br />
                <br />
                <br />
                <br />
                <br />
            	<p><?php echo $p1; ?></p>
                <br />
                <br />
                <br />	
                <p>Clique em<strong>&nbsp;Voltar&nbsp;</strong>para iniciar uma nova marcação de consulta.</p>
                
                <div id="botoes">
                    <form method="post" action="consulta.php" name="frmBotoes" id="frmBotoes" enctype="multipart/form-data">
                        <input type="submit" id="btnVoltar" name="btnVoltar" value="Voltar" class="designBotao" />
                    </form>
                </div>
			</div>
<?php include "footer_sistemas.php"; ?>