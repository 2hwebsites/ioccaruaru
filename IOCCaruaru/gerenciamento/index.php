<?php 
	include "header.php";
	
	include "../connections/conn.php";
	
	$sql_permissoes = "SELECT ip.descricao 
						FROM ioc_usuarios AS iu 
						INNER JOIN ioc_usuario_permissao AS iup ON iu.id = iup.usuario_id 
						INNER JOIN ioc_permissoes AS ip ON iup.permissao_id = ip.id
						WHERE iu.id = ".$usuario['id'];
	$permissoesQy = mysqli_query($conn, $sql_permissoes) Or die('Erro ao obter permissões. '.mysqli_error($conn));
	
	mysqli_close($conn);	
	
	if(@mysqli_num_rows($permissoesQy) == '0'){
		echo "Usuário sem nenhuma permissão.";
	}else{
		$cont = 0;
		$permissoes = array();
		
		while($res_permissoes = mysqli_fetch_array($permissoesQy)){
			$permissoes[$cont] = $res_permissoes[0];
			
			$cont++;
		}
	}
	
	$administrador = 0;
	
	if(in_array("administra", $permissoes)){
		$administrador = 1;
	}
?>
        	<div id="page">
                <span class="menu_categoria">PÁGINA INICIAL</span>
                <br />
                <br />
                <ul>
<?php if($administrador || in_array("conteudo", $permissoes)){ ?>
                    <li><a href="index.php?p=galerias&amp;cat=1&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Galeria</a></li>
                    <li><a href="index.php?p=noticias&amp;cat=2&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Notícias</a></li>
                    <li><a href="index.php?p=dicas&amp;cat=3&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Dicas de Saúde</a></li>
                    <li><a href="index.php?p=carrosseis&amp;cat=4&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Carrossel</a></li>
                    <li><a href="index.php?p=banners&amp;cat=5&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Banner</a></li>
                    <li><a href="index.php?p=revistas&amp;cat=6&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Revista</a></li>
<?php } 
	  if($administrador || in_array("cadusuario", $permissoes)){ ?>
                    <li><a href="index.php?p=usuarios&amp;cat=7&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Usuário</a></li>
<?php } 
	  if($administrador || in_array("exame", $permissoes)){ ?>
                    <li><a href="index.php?p=exames&amp;cat=8&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Exame</a></li>
<?php } 
	  if($administrador || in_array("consulta", $permissoes)){ ?>
                    <li><a href="index.php?p=consultas&amp;cat=9&amp;us=<?php echo $usuario['id']; ?>" class="menu_subcategoria">Consulta</a></li>
<?php } ?>
                </ul>
                <br />
            </div>
        
            <div id="conteudo">
<?php
	foreach ($_REQUEST as $___opt => $___val){
		$$___opt = $___val;
	}
	
	if(empty($p)){
		include("home.php");
	}
	elseif(substr($p, 0, 4)=='http' or substr($p, 0, 1)=="/" or substr($p, 0, 1)=="."){
		echo '<br /><font face=arial size=11px><br /><b>A página não existe.</b><br />Por favor selecione uma página a partir do menu principal.';
	}
	else{
		include("$p.php");
	}
?>
            </div>
<?php include "footer.php"; ?>