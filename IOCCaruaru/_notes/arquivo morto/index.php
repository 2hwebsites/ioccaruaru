<?php include "header.php"; ?>

<?php
	foreach ($_REQUEST as $___opt => $___val){
		$$___opt = $___val;
	}
	
	if(empty($pagina)){
		include("nav/home.php");
	}
	elseif(substr($pagina, 0, 4)=='http' or substr($pagina, 0, 1)=="/" or substr($pagina, 0, 1)=="."){
		echo '<br /><font face=arial size=11px><br /><b>A página não existe.</b><br />Por favor selecione uma página a partir do menu principal.';
	}
	else{
		include("$pagina.php");
	}
?>

<?php include "footer.php"; ?>
