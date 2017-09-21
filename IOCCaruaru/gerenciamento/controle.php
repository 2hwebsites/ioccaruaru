<?php 
	//inicializa variaveis
	$migalha = "home";

	//verifica a categoria
	if(isset($_GET['cat'])){
		include "../connections/conn.php";
		$categoria = mysqli_fetch_assoc(mysqli_query($conn, "select * from ioc_categoria where id='$_GET[cat]'"));
		mysqli_close($conn);
		$migalha = $categoria['nome'];
	}

	switch (@$_GET['acao']){
		case '1':
			$migalha = $migalha." > Novo";
			break;
	
		case '2':
			$migalha = $migalha." > Editar";
			break;
	
		case '3':
			$migalha = $migalha." > Conteúdos Excluídos";
			break;									
	}
?>