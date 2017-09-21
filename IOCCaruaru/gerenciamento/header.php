<?php
	if(!isset($_GET['us'])){
		header("Location:login.php");
	}
	$usuario = $_GET['us'];
	 
	setlocale (LC_ALL, 'pt_BR', 'ptb', 'pt_BR.utf-8');
	$data_atual = strftime("%A, %d de %B de %Y");
	
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['sair'])){
		header("Location:login.php");
	}
	
	include "../funcoes.php";
	include "controle.php";
	include "../connections/conn.php";
	
	$sql_usuario = "SELECT * FROM ioc_usuarios WHERE id = '$usuario'";
	$query_usuario = mysqli_query($conn, $sql_usuario) or die(mysqli_error($conn));
	$qtd_usuario = mysqli_num_rows($query_usuario);
	
	if ($qtd_usuario==0){
		$resposta = "<div id='erroLogin'>Usuário não encontrado!</div>";
	}else{
		$usuario = mysqli_fetch_assoc($query_usuario);
	}
	mysqli_close($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt,BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Gerenciador de Conteúdo - IOC</title>
    <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
    <link href="style_manages.css" rel="stylesheet" type="text/css" />

<?php include "scripts.php"; ?>
</head>

<body>
	<div id="box">
    	<header>
        <div id="header">
        	<div id="cabecalho">
                <img src="img/logo.fw.png" alt="" />
                <h1 class="tit_cliente">Gerenciador de Conteúdo - IOC</h1>    
            </div>
            
            <div id="usuario_logado">
                <span class="legenda-usuario">Usuário: <a href="login.php">trocar</a></span>
                <br />
                <b><?php echo $usuario['nome_resumido']; ?></b>
            </div>
            
            <div id="data-acesso">
                <span class="legenda-usuario">Último acesso:</span>
                <br />
                <b>
                <?php
                    $data   = $usuario['data_ultimo_login'];
                    $hora   = substr($data, 11, 5);
                    $data   = converte_data(substr($data, 0, 10));
                    echo $data . ' às '.$hora ;
                ?>
                </b>
            </div>
            
            <div id="data-atual">
                <span><?php echo $data_atual;?></span>
            </div>

            <img src="img/img_menu.gif" class="img-menu" />
            <img src="img/linha_separadora_v.gif" class="linha-separadora" />

<?php if(isset($_GET['cat'])){ ?>
			<div id="menu-crud">
                <a href="#" id="conteudo_novo" title="Novo" onclick="selecionarPagina(<?php echo $_GET['cat']; ?>, 'novo', <?php echo $usuario['id']; ?>)">
                    <img src="img/bt_nova.gif" class="img-menu-crud" />
                </a>
<?php if(!isset($_GET['acao'])){ ?>
                <a href="#" id="editar_conteudo" title="Editar" onclick="selecionarPagina(<?php echo $_GET['cat']; ?>, 'editar', <?php echo $usuario['id']; ?>)">
                    <img src="img/bt_editar.gif" class="img-menu-crud" />
                </a>
<?php } if($_GET['cat'] == 1){ ?>        
                <a href="#" id="galeria" title="Galeria de imagens" onclick="selecionarPagina(1, 'galeria', <?php echo $usuario['id']; ?>)">
                    <img src="img/bt_maisgaleria.gif" class="img-menu-crud" />
                </a>
<?php } if(!isset($_GET['acao'])){ ?>
                <a href="#" id="excluir" title="Excluir" onclick="selecionarPagina(<?php echo $_GET['cat']; ?>, 'excluir', <?php echo $usuario['id']; ?>)">
                    <img src="img/bt_excluir.gif" class="btn-excluir img-menu-crud" />
                </a>
<?php } ?>
                <a href="#" id="itens_excluidos" title="Itens Excluídos" onclick="selecionarPagina(<?php echo $_GET['cat']; ?>, 'excluidos', <?php echo $usuario['id']; ?>)">
                    <img src="img/download.jpg" class="btn-excluir img-menu-crud" />
                </a>
            </div>
<?php } ?>
			<div id="menu-home">
                <form id="sair" name="form1" method="post" action="">
                    <input src="img/bt_fechar.gif" type="image" />
                    <input type="hidden" value="sair"  name="sair"/>
                </form>
                    
                <a href="index.php?&us=<?php echo $usuario['id']; ?>">
                    <img src="img/bt_inicio.gif" class="img-menu-superior" />
                </a>
            </div>
            
            <div id="caminho">
                <span class="caminho">você esta aqui:</span>
                <span class="caminho_id"><?php echo $migalha; ?></span>
            </div>
        </div>
        </header>
        
        <article>
        <div id="content">