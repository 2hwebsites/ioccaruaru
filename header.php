<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>IOC - Instituto de Olhos de Caruaru</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="img/logo-circulo-IOC.fw.png" type="image/x-icon" />
<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">

<!-- Start WOWSlider.com HEAD section -->
<link rel="stylesheet" type="text/css" href="engine1/style.css"  media="screen" />
<style type="text/css">a#vlb{display:none}</style>
<script type="text/javascript" src="engine1/jquery.js"></script>
<!-- End WOWSlider.com HEAD section -->

<?php 
	if(!(isset($url_face) && isset($titulo) && isset($subtitulo) && isset($video) && isset($descricao) && isset($id_single) &&
		isset($thumb_banner) && isset($thumb))){ 
		$url_face = "";
		$titulo = "";
		$subtitulo = "";
		$video = "";
		$descricao = "";
		$id_single = "";
		$thumb_banner = "";
		$thumb = "";
	}
?>

<!--PARA ACEITAR ACENTOS-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--CONTEÚDO EM PORTUGUÊS-->
<meta property="og:locale" content="pt_BR">

<!--URL DO SITE-->
<meta property="og:url" content="<?php echo $url_face; ?>">

<!--TÍTULO E NOME DO SITE-->
<meta property="og:title" content="<?php echo $titulo; ?>">
<meta property="og:site_name" content="IOC - Institulo de Olhos de Caruaru">

<!-- DESCRIÇÃO DO SITE-->
<meta property="og:description" content="<?php echo $subtitulo; ?>">

<?php
if($video <> ''){
?>
	<meta property="og:video" content="http://example.com/bond/trailer.swf" />
<?php
} else{
	$img = "../upload/".$descricao."/".sprintf("%06d", $id_single)."/";
	if($thumb_banner <> ''){ 
    	$img = $img."banner/".$thumb_banner;
	} else{
		$img = $img."img_g/".$thumb;
	}
?>
    <!-- IMAGEM DO SITE -->
    <meta property="og:image" content="<?php echo $img; ?>"/>
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
<?php 
}

include "scripts.php";
include "funcoes.php"; 
?>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=235267203658583";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="gridContainer clearfix">
	<header id="cabecalho">
        <div id="logo" >
	        <img src="img/logo.jpg" alt="Logo Instituto de Olhos de Caruaru" />
        </div>
        
        <div id="rede_social">
   	  		<h3 align="center">Acompanhe o IOC</h3>
            <div id="botoes_rs" align="center">
                <a href="https://www.facebook.com/ioc.caruaru/" target="_blank">
                    <img src="img/logo-facebook.jpg" alt="Logo Facebook" class="rs_mg_esq" />
                </a>
                <a href="https://www.instagram.com/ioccaruaru/" target="_blank">
                    <img src="img/logo-insta.jpg" alt="Logo Instagran" />
                </a>
                <a href="https://twitter.com/ioc_caruaru" target="_blank">
                    <img src="img/logo-twitter.jpg" alt="Logo Twitter" class="last" />
                </a>
			</div>
        </div>
        
        <div id="exame">
            <form name="entrega_exame" action="breve.php" target="_blank" method="post" onSubmit="return criticaExame(this);">
                <fieldset>
                  <legend><span>Resultado do </span>Exame</legend>
                  <input id="atendimento" name="atendimento" type="text" placeholder="Atendimento" maxlength="6" 
                  	onkeypress="return SomenteNumero(event)" />
                    
                 <input id="senha" name="senha" type="password" maxlength="8" placeholder="Senha" 
                 	onkeypress="return SomenteNumero(event)" />
                    
                  <input name="Ok" type="submit" value="OK" class="btn_ok" />
                </fieldset>
            </form>
		</div>
        
        <nav id="menu">                
            <ul class="omiteMobile">
                <li>
                    <a href="index.php?pagina=nav/home">Home</a>
                </li>
                <li>
                    <a href="#">Empresa</a>
                    <ul class="submenu">
                        <li class="borda-baixo">
                            <a href="index.php?pagina=nav/page&amp;url=empresa">O IOC</a>
                        </li>
                        <li class="borda-baixo borda-reta">
                            <a href="index.php?pagina=nav/page&amp;url=equipe">Equipe</a>
                        </li>
                        <li class="borda-baixo borda-reta">
                            <a href="index.php?pagina=nav/page&amp;url=convênios">Convênios</a>
                        </li>
                        <li class="borda-reta">
                            <a href="index.php?pagina=nav/trabalhe-conosco">Trabalhe Conosco</a>
                        </li>
                        <li class="borda-cima borda-reta omite_ContatoEmpresa">
                            <a href="index.php?pagina=nav/contato">Contato</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Serviços</a>
                    <ul class="submenu">
                    	<li class="borda-baixo borda-reta omite_GaleriaNoticia">
                            <a href="breve.php" target="_blank">Consulta</a>
                        </li>
                        <li class="borda-baixo">
                            <a href="index.php?pagina=nav/page&amp;url=cirurgias">Cirurgias</a>
                        </li>
                        <li class="borda-reta">
                            <a href="index.php?pagina=nav/page&amp;url=exames">Exames</a>
                        </li>
                    </ul>
                </li>
                <li class="omite_Galeria">
                    <a href="#">Marcação</a>
                    <ul class="submenu">
                        <li>
                            <a href="breve.php" target="_blank">Consulta</a>
                        </li>
                    </ul>
                </li>
                <li class="omite_Galeria">
                    <a href="index.php?pagina=nav/info&amp;cat=1&amp;pag=1">Galeria</a>
                </li>
                <li>
                    <a href="#">Notícias</a>
                    <ul class="submenu">
                    	<li  class="borda-baixo borda-reta omite_GaleriaNoticia">
                            <a href="index.php?pagina=nav/info&amp;cat=1&amp;pag=1">Galeria</a>
                        </li>
                        <li class="borda-baixo">
                            <a href="index.php?pagina=nav/info&amp;cat=2&amp;pag=1">IOC</a>
                        </li>
                        <li class="borda-reta">
                            <a href="index.php?pagina=nav/info&amp;cat=3&amp;pag=1">Dicas de Saúde</a>
                        </li>
                        <li class="borda-cima borda-reta omite_ContatoEmpresa">
                            <a href="index.php?pagina=nav/revista">Revista</a>
                        </li>
                    </ul>
                </li>
                <li class="omite_Contato">
                    <a href="index.php?pagina=nav/revista">Revista</a>
                </li>
                <li class="omite_Contato">
                    <a href="index.php?pagina=nav/contato">Contato</a>
                </li>
            </ul>
            
            <ul class="exibeMobile">
            	<li>
                	<img src="img/botao_menu.fw.png" />
                	<ul class="submenu">
                        <li class="borda-baixo-branca">
                            <a href="index.php?pagina=nav/home">Home</a>
                        </li>
                        <li class="borda-baixo-branca">
                        	<p>Empresa</p>
                        	<ul class="submenu">
                                <li class="borda-baixo">
                                    <a href="index.php?pagina=nav/page&amp;url=empresa">O IOC</a>
                                </li>
                                <li class="borda-baixo borda-reta">
                                    <a href="index.php?pagina=nav/page&amp;url=equipe">Equipe</a>
                                </li>
                                <li class="borda-baixo borda-reta">
                                    <a href="index.php?pagina=nav/page&amp;url=convênios">Convênios</a>
                                </li>
                                <li class="borda-reta">
                                    <a href="index.php?pagina=nav/trabalhe-conosco">Trabalhe Conosco</a>
                                </li>
                                <li class="borda-cima borda-reta omite_ContatoEmpresa">
                                    <a href="index.php?pagina=nav/contato">Contato</a>
                                </li>
                        	</ul>
                        </li>
                        <li class="borda-baixo-branca">
                            <p>Serviços</p>
                            <ul class="submenu">
                            	<li class="borda-baixo borda-reta omite_GaleriaNoticia">
                                    <a href="breve.php" target="_blank">Consulta</a>
                                </li>
                                <li class="borda-baixo">
                                    <a href="index.php?pagina=nav/page&amp;url=cirurgias">Cirurgias</a>
                                </li>
                                <li class="borda-reta">
                                    <a href="breve.php">Exames</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <p>Notícias</p>
                            <ul class="submenu">
                                <li  class="borda-baixo borda-reta omite_GaleriaNoticia">
                                    <a href="index.php?pagina=nav/info&amp;cat=1&amp;pag=1">Galeria</a>
                                </li>
                                <li class="borda-baixo">
                                    <a href="index.php?pagina=nav/info&amp;cat=2&amp;pag=1">IOC</a>
                                </li>
                                <li class="borda-reta">
                                    <a href="index.php?pagina=nav/info&amp;cat=3&amp;pag=1">Dicas de Saúde</a>
                                </li>
                                <li class="borda-cima borda-reta omite_ContatoEmpresa">
                                    <a href="index.php?pagina=nav/revista">Revista</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
                 
            <form class="pesquisar" action="index.php?pagina=nav/search&amp;pg=1" method="post">
                <input type="submit" name="pesquisar" value="" class="btn_pesquisar" />
                <input name="pesquisa" type="text" placeholder="Pesquisar" />
            </form>
        </nav>
    </header>
    
    <article>